<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SinistreController extends Controller
{
    public function index()
    {
        $structure = Auth::guard('structure')->user();
        $sinistres = Sinistre::where('structure_id', $structure->id)
            ->with('caserneAssignee')
            ->latest()
            ->paginate(15);

        return view('structure.sinistre.index', compact('sinistres'));
    }

    public function show(Sinistre $sinistre)
    {
        // Sécurité : Vérifier que le sinistre appartient bien à la structure
        if ($sinistre->structure_id !== Auth::guard('structure')->id()) {
            abort(403);
        }

        // Définition des checklists par type de sinistre
        $checklists = [
            'Incendie' => [
                'Évacuer tout le personnel vers le point de rassemblement.',
                'Couper l\'alimentation électrique et le gaz du secteur concerné.',
                'Fermer les portes et fenêtres si possible pour ralentir la propagation.',
                'Dégager les accès pour l\'arrivée des camions de pompiers.'
            ],
            'Accident de la circulation' => [
                'Sécuriser la zone avec des triangles de pré-signalisation.',
                'Ne pas déplacer les blessés graves sauf danger immédiat.',
                'Couper le contact des véhicules impliqués.',
                'Répertorier le nombre approximatif de victimes.'
            ],
            'Inondation' => [
                'Mettre en sécurité les équipements électriques et électroniques.',
                'Boucher les entrées d\'eau basses si possible.',
                'Éviter de toucher aux installations électriques les pieds dans l\'eau.',
                'Préparer une liste des produits chimiques ou dangereux exposés.'
            ],
            'Effondrement d\'immeuble' => [
                'Établir un périmètre de sécurité immédiat.',
                'Couper les arrivées d\'eau et de gaz.',
                'Interdire tout accès à la structure instable.',
                'Tenter de recenser les personnes manquantes à l\'appel.'
            ],
            'Default' => [
                'Garder son calme et rassurer les personnes présentes.',
                'Suivre les instructions données par les secours au téléphone.',
                'Dégager les voies d\'accès pour les véhicules d\'urgence.'
            ]
        ];

        $protocol = $checklists[$sinistre->type_sinistre] ?? $checklists['Default'];

        return view('structure.sinistre.show', compact('sinistre', 'protocol'));
    }

    public function escalate(Sinistre $sinistre)
    {
        if ($sinistre->structure_id !== Auth::guard('structure')->id()) {
            abort(403);
        }

        if ($sinistre->status !== 'resolu' && $sinistre->status !== 'termine') {
            $sinistre->update([
                'status' => 'en_cours', // S'il était en attente
                'description' => $sinistre->description . "\n\n[URGENCE CRITIQUE - " . now()->format('H:i') . "] : La situation s'est aggravée sur place !"
            ]);
        }

        return back()->with('success', 'Alerte d\'escalade envoyée. Les secours ont été informés de l\'aggravation de la situation.');
    }

    public function create()
    {
        return view('structure.sinistre.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type_sinistre' => 'required|string',
            'description'   => 'required|string',
            'lieu'          => 'required|string',
            'latitude'      => 'required',
            'longitude'     => 'required',
        ]);

        $structure = Auth::guard('structure')->user();

        $data = [
            'nom_complet'   => $structure->nom,
            'contact'       => $structure->contact,
            'type_sinistre' => $request->type_sinistre,
            'description'   => $request->description,
            'lieu'          => $request->lieu,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'status'        => 'en_attente',
            'structure_id'  => $structure->id,
        ];

        // Gérer les images si présentes
        if ($request->hasFile('image1')) {
            $data['image1'] = $request->file('image1')->store('sinistres', 'public');
        }
        if ($request->hasFile('image2')) {
            $data['image2'] = $request->file('image2')->store('sinistres', 'public');
        }

        $sinistre = Sinistre::create($data);

        // ── Trouver la caserne la plus proche ──────────────────────────
        $lat = (float) $request->latitude;
        $lng = (float) $request->longitude;

        $caserneProche = User::where('role', 'caserne')
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->get()
            ->map(function ($caserne) use ($lat, $lng) {
                $caserne->distance = $this->haversine(
                    $lat, $lng,
                    (float) $caserne->latitude,
                    (float) $caserne->longitude
                );
                return $caserne;
            })
            ->sortBy('distance')
            ->first();

        if ($caserneProche) {
            // Assigner la caserne la plus proche
            $sinistre->update(['assigned_caserne_id' => $caserneProche->id]);

            // Enregistrer dans la table pivot avec la distance
            $sinistre->casernes()->attach($caserneProche->id, [
                'distance' => round($caserneProche->distance, 2),
            ]);
        }
        // ──────────────────────────────────────────────────────────────

        return redirect()
            ->route('structure.dashboard')
            ->with('success', 'Alerte envoyée ! La caserne la plus proche (' .
                ($caserneProche ? $caserneProche->name : 'inconnue') . ') a été notifiée.');
    }

    /**
     * Formule de Haversine — distance en kilomètres entre deux points GPS.
     */
    private function haversine(float $lat1, float $lng1, float $lat2, float $lng2): float
    {
        $earthRadius = 6371; // km

        $dLat = deg2rad($lat2 - $lat1);
        $dLng = deg2rad($lng2 - $lng1);

        $a = sin($dLat / 2) ** 2
           + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng / 2) ** 2;

        return $earthRadius * 2 * asin(sqrt($a));
    }
}
