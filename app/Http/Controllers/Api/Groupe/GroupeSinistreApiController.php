<?php

namespace App\Http\Controllers\Api\Groupe;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GroupeSinistreApiController extends Controller
{
    /**
     * Tableau de bord : sinistres en attente liés à la caserne parente
     * GET /api/groupe/dashboard
     */
    public function dashboard(Request $request)
    {
        $groupe  = $request->user();
        $caserne = $groupe->caserneParent;

        if (!$caserne) {
            return response()->json([
                'success' => false,
                'message' => 'Ce groupe n\'est rattaché à aucune caserne.',
            ], 403);
        }

        $sinistres = Sinistre::where('status', 'en_attente')
            ->whereHas('casernes', function ($query) use ($caserne) {
                $query->where('users.id', $caserne->id);
            })
            ->latest()
            ->get();

        $totalEnAttente = $sinistres->count();

        return response()->json([
            'success'   => true,
            'groupe'    => [
                'id'        => $groupe->id,
                'name'      => $groupe->name,
                'telephone' => $groupe->telephone,
                'caserne'   => [
                    'id'      => $caserne->id,
                    'name'    => $caserne->name,
                    'contact' => $caserne->telephone,
                    'adresse' => $caserne->adresse,
                ],
            ],
            'stats'     => [
                'en_attente' => $totalEnAttente,
            ],
            'sinistres' => $sinistres->map(fn($s) => $this->formatSinistre($s)),
        ], 200);
    }

    /**
     * Interventions en cours assignées au groupe
     * GET /api/groupe/interventions
     */
    public function interventions(Request $request)
    {
        $groupe = $request->user();

        $sinistres = Sinistre::where('assigned_caserne_id', $groupe->id)
            ->where('status', 'en_cours')
            ->latest()
            ->get();

        return response()->json([
            'success'   => true,
            'count'     => $sinistres->count(),
            'sinistres' => $sinistres->map(fn($s) => $this->formatSinistre($s)),
        ], 200);
    }

    /**
     * Interventions terminées assignées au groupe
     * GET /api/groupe/interventions-terminees
     */
    public function interventionsTerminees(Request $request)
    {
        $groupe = $request->user();

        $sinistres = Sinistre::where('assigned_caserne_id', $groupe->id)
            ->where('status', 'termine')
            ->latest('date_cloture')
            ->get();

        return response()->json([
            'success'   => true,
            'count'     => $sinistres->count(),
            'sinistres' => $sinistres->map(fn($s) => $this->formatSinistre($s)),
        ], 200);
    }

    /**
     * Télécharger le PDF de l'intervention
     * GET /api/groupe/sinistre/{sinistre}/pdf
     */
    public function downloadPdf(Request $request, Sinistre $sinistre)
    {
        $token = $request->query('token');
        if (!$token) {
            return response()->json(['success' => false, 'message' => 'Token manquant.'], 401);
        }
        
        $accessToken = \Laravel\Sanctum\PersonalAccessToken::findToken($token);
        if (!$accessToken || !$accessToken->tokenable) {
            return response()->json(['success' => false, 'message' => 'Token invalide ou expiré.'], 401);
        }
        
        $groupe = $accessToken->tokenable;

        if ($sinistre->assigned_caserne_id !== $groupe->id || $sinistre->status !== 'termine') {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à télécharger cette intervention.',
            ], 403);
        }

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('groupe.pdf.intervention-terminee', [
            'sinistre' => $sinistre,
            'groupe' => $groupe,
            'caserne' => $groupe->caserneParent,
        ])->setPaper('a4', 'portrait');

        $reference = $sinistre->reference ?? 'SN-' . $sinistre->id;

        return $pdf->download($reference . '-intervention-cloturee.pdf');
    }

    /**
     * Détail d'un sinistre (si le groupe y est autorisé)
     * GET /api/groupe/sinistre/{sinistre}
     */
    public function show(Request $request, Sinistre $sinistre)
    {
        $groupe  = $request->user();
        $caserne = $groupe->caserneParent;

        $isAuthorized = $sinistre->assigned_caserne_id === $groupe->id
            || ($caserne && $sinistre->casernes()->where('users.id', $caserne->id)->exists());

        if (!$isAuthorized) {
            return response()->json([
                'success' => false,
                'message' => 'Accès non autorisé à ce sinistre.',
            ], 403);
        }

        return response()->json([
            'success'  => true,
            'sinistre' => $this->formatSinistre($sinistre, true),
        ], 200);
    }

    /**
     * Démarrer une intervention (claim)
     * POST /api/groupe/sinistre/{sinistre}/demarrer
     */
    public function demarrer(Request $request, Sinistre $sinistre)
    {
        $groupe          = $request->user();
        $caserneParentId = $groupe->caserne_id;

        if (!$caserneParentId || !$sinistre->casernes()->where('users.id', $caserneParentId)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'Ce sinistre ne relève pas de votre caserne.',
            ], 403);
        }

        if ($sinistre->status !== 'en_attente') {
            return response()->json([
                'success' => false,
                'message' => 'Ce sinistre n\'est plus disponible (statut: ' . $sinistre->status . ').',
            ], 409);
        }

        if ($sinistre->assigned_caserne_id && $sinistre->assigned_caserne_id !== $groupe->id) {
            return response()->json([
                'success' => false,
                'message' => 'Ce sinistre a déjà été attribué à un autre groupe.',
            ], 409);
        }

        $sinistre->update([
            'assigned_caserne_id' => $groupe->id,
            'status'              => 'en_cours',
        ]);

        // Envoyer un SMS au déclarant
        if ($sinistre->contact) {
            $message = "Bonjour " . $sinistre->nom_complet . ", votre déclaration a été reçue et prise en charge par le groupe " . $groupe->name . ". Nous arrivons au plus vite.";
            SmsService::send($sinistre->contact, $message);
        }

        return response()->json([
            'success'  => true,
            'message'  => 'Intervention démarrée avec succès.',
            'sinistre' => $this->formatSinistre($sinistre->fresh()),
        ], 200);
    }

    /**
     * Soumettre l'état des lieux et clôturer l'intervention
     * POST /api/groupe/sinistre/{sinistre}/etat-des-lieux
     */
    public function etatDesLieux(Request $request, Sinistre $sinistre)
    {
        $groupe = $request->user();

        if ($sinistre->assigned_caserne_id !== $groupe->id) {
            return response()->json([
                'success' => false,
                'message' => 'Vous n\'êtes pas autorisé à clôturer cet incident.',
            ], 403);
        }

        if ($sinistre->status !== 'en_cours') {
            return response()->json([
                'success' => false,
                'message' => 'Seule une intervention en cours peut être clôturée.',
            ], 409);
        }

        $validated = $request->validate([
            'rapport_intervention' => 'required|string|min:10',
            'nb_morts'             => 'nullable|integer|min:0',
            'nb_blesses'           => 'nullable|integer|min:0',
            'nb_evacues'           => 'nullable|integer|min:0',
        ]);

        $sinistre->update([
            'rapport_intervention' => $validated['rapport_intervention'],
            'nb_morts'             => $validated['nb_morts'] ?? 0,
            'nb_blesses'           => $validated['nb_blesses'] ?? 0,
            'nb_evacues'           => $validated['nb_evacues'] ?? 0,
            'status'               => 'termine',
            'date_cloture'         => now(),
        ]);

        return response()->json([
            'success'  => true,
            'message'  => 'Intervention clôturée avec succès.',
            'sinistre' => $this->formatSinistre($sinistre->fresh()),
        ], 200);
    }

    /**
     * Formater un sinistre pour la réponse API
     */
    private function formatSinistre(mixed $s, bool $withDetails = false): array
    {
        $data = [
            'id'            => $s->id,
            'reference'     => $s->reference ?? 'SN-' . $s->id,
            'nom_complet'   => $s->nom_complet,
            'contact'       => $s->contact,
            'type_sinistre' => $s->type_sinistre,
            'lieu'          => $s->lieu ?? 'Lieu non renseigné',
            'latitude'      => $s->latitude,
            'longitude'     => $s->longitude,
            'status'        => $s->status,
            'created_at'    => $s->created_at?->toIso8601String(),
            'date_cloture'  => $s->date_cloture?->toIso8601String(),
            'image1'        => $s->image1 ? asset('storage/' . $s->image1) : null,
            'image2'        => $s->image2 ? asset('storage/' . $s->image2) : null,
            'image3'        => $s->image3 ? asset('storage/' . $s->image3) : null,
        ];

        if ($withDetails) {
            $data['description']           = $s->description;
            $data['rapport_intervention']  = $s->rapport_intervention;
            $data['nb_morts']              = $s->nb_morts ?? 0;
            $data['nb_blesses']            = $s->nb_blesses ?? 0;
            $data['nb_evacues']            = $s->nb_evacues ?? 0;
        }

        return $data;
    }
}
