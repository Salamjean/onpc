<?php

namespace App\Http\Controllers\Caserne;

use App\Http\Controllers\Controller;
use App\Services\SmsService;
use App\Models\GroupePersonne;
use App\Mail\GroupeOtpMail;
use App\Models\Sinistre;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class GroupeController extends Controller
{
    public function dashboard()
    {
        $groupe = Auth::user();
        $caserne = $groupe->caserneParent;
        $sinistres = Sinistre::query()
            ->where('status', 'en_attente')
            ->whereHas('casernes', function ($query) use ($caserne) {
                $query->where('users.id', $caserne?->id);
            })
            ->latest()
            ->paginate(10);

        $sinistresEnAttente = Sinistre::query()
            ->where('status', 'en_attente')
            ->whereHas('casernes', function ($query) use ($caserne) {
                $query->where('users.id', $caserne?->id);
            })
            ->count();

        if (request()->ajax()) {
            return view('groupe.partials.sinistres_table', compact('sinistres'));
        }

        return view('groupe.dashboard', compact('groupe', 'caserne', 'sinistres', 'sinistresEnAttente'));
    }

    public function interventions()
    {
        $groupe = Auth::user();
        $caserne = $groupe->caserneParent;

        $sinistres = Sinistre::where('assigned_caserne_id', $groupe->id)
            ->where('status', 'en_cours')
            ->latest()
            ->paginate(10);

        $interventionsCount = Sinistre::where('assigned_caserne_id', $groupe->id)
            ->where('status', 'en_cours')
            ->count();

        if (request()->ajax()) {
            return view('groupe.partials.interventions_table', compact('sinistres'));
        }

        return view('groupe.interventions', compact('groupe', 'caserne', 'sinistres', 'interventionsCount'));
    }

    public function interventionsTerminees()
    {
        $groupe = Auth::user();
        $caserne = $groupe->caserneParent;

        $sinistres = Sinistre::where('assigned_caserne_id', $groupe->id)
            ->where('status', 'termine')
            ->latest('date_cloture')
            ->paginate(10);

        $interventionsTermineesCount = Sinistre::where('assigned_caserne_id', $groupe->id)
            ->where('status', 'termine')
            ->count();

        return view('groupe.interventions-terminees', compact(
            'groupe',
            'caserne',
            'sinistres',
            'interventionsTermineesCount'
        ));
    }

    public function showInterventionTerminee(Sinistre $sinistre)
    {
        $groupe = Auth::user();
        $caserne = $groupe->caserneParent;

        if ($sinistre->assigned_caserne_id !== $groupe->id || $sinistre->status !== 'termine') {
            abort(403, 'Vous n\'etes pas autorise a consulter cette intervention cloturee.');
        }

        return view('groupe.interventions.show-terminee', compact('sinistre', 'groupe', 'caserne'));
    }

    public function downloadInterventionTerminee(Sinistre $sinistre)
    {
        $groupe = Auth::user();

        if ($sinistre->assigned_caserne_id !== $groupe->id || $sinistre->status !== 'termine') {
            abort(403, 'Vous n\'etes pas autorise a telecharger cette intervention cloturee.');
        }

        $pdf = Pdf::loadView('groupe.pdf.intervention-terminee', [
            'sinistre' => $sinistre,
            'groupe' => $groupe,
            'caserne' => $groupe->caserneParent,
        ])->setPaper('a4', 'portrait');

        $reference = $sinistre->reference ?? 'SN-' . $sinistre->id;

        return $pdf->download($reference . '-intervention-cloturee.pdf');
    }

    public function claim(Sinistre $sinistre)
    {
        $groupe = Auth::user();
        $caserneParentId = $groupe->caserne_id;

        if (!$caserneParentId || !$sinistre->casernes()->where('users.id', $caserneParentId)->exists()) {
            return back()->with('error', 'Ce sinistre ne relève pas de votre caserne.');
        }

        if ($sinistre->status !== 'en_attente') {
            return back()->with('error', 'Ce sinistre n\'est plus disponible.');
        }

        if ($sinistre->assigned_caserne_id && $sinistre->assigned_caserne_id !== $groupe->id) {
            return back()->with('error', 'Ce sinistre a déjà été attribué à un autre groupe.');
        }

        $sinistre->update([
            'assigned_caserne_id' => $groupe->id,
            'status' => 'en_cours',
        ]);

        // Envoyer un SMS au déclarant immédiatement
        if ($sinistre->contact) {
            $message = "Bonjour " . $sinistre->nom_complet . ", votre déclaration a été reçue et prise en charge par le groupe " . $groupe->name . ". Nous arrivons au plus vite.";
            SmsService::send($sinistre->contact, $message);
        }

        return redirect()->route('caserne.groupe.interventions.index')->with('success', 'Le sinistre vous a été attribué avec succès.');
    }

    public function index()
    {
        $caserne = Auth::user();

        $groupes = User::where('role', 'groupe')
            ->where('caserne_id', $caserne->id)
            ->withCount('personnesDuGroupe')
            ->latest()
            ->paginate(12);

        return view('caserne.groupes.index', compact('groupes', 'caserne'));
    }

    public function create()
    {
        $caserne = Auth::user();

        $groupesCount = User::where('role', 'groupe')
            ->where('caserne_id', $caserne->id)
            ->count();

        return view('caserne.groupes.create', compact('caserne', 'groupesCount'));
    }

    public function createPersonne(User $groupe)
    {
        $caserne = Auth::user();

        if ($groupe->role !== 'groupe' || $groupe->caserne_id !== $caserne->id) {
            abort(403, 'Groupe non autorise.');
        }

        $groupe->load(['personnesDuGroupe' => function ($query) {
            $query->orderByRaw('archived_at IS NULL DESC')->latest();
        }]);

        $interventionsQuery = Sinistre::where('assigned_caserne_id', $groupe->id);

        $stats = [
            'personnes_total' => $groupe->personnesDuGroupe()->count(),
            'personnes_actives' => $groupe->personnesDuGroupe()->whereNull('archived_at')->count(),
            'personnes_archivees' => $groupe->personnesDuGroupe()->whereNotNull('archived_at')->count(),
            'interventions_total' => (clone $interventionsQuery)->count(),
            'interventions_en_cours' => (clone $interventionsQuery)->where('status', 'en_cours')->count(),
            'interventions_terminees' => (clone $interventionsQuery)->whereIn('status', ['resolu', 'termine'])->count(),
            'interventions_aujourdhui' => (clone $interventionsQuery)->whereDate('created_at', today())->count(),
        ];

        $dernieresInterventions = (clone $interventionsQuery)
            ->latest()
            ->limit(3)
            ->get();

        $personneEnEdition = null;
        $editPersonneId = request()->integer('edit_personne');
        if ($editPersonneId) {
            $personneEnEdition = GroupePersonne::where('id', $editPersonneId)
                ->where('groupe_id', $groupe->id)
                ->first();
        }

        return view('caserne.groupes.personnes.create', compact('caserne', 'groupe', 'stats', 'dernieresInterventions', 'personneEnEdition'));
    }

    public function interventionsListe(User $groupe)
    {
        $caserne = Auth::user();

        if ($groupe->role !== 'groupe' || $groupe->caserne_id !== $caserne->id) {
            abort(403, 'Groupe non autorise.');
        }

        $interventions = Sinistre::where('assigned_caserne_id', $groupe->id)
            ->latest()
            ->paginate(12);

        return view('caserne.groupes.personnes.interventions', compact('caserne', 'groupe', 'interventions'));
    }

    public function storePersonne(Request $request, User $groupe)
    {
        $caserne = Auth::user();

        if ($groupe->role !== 'groupe' || $groupe->caserne_id !== $caserne->id) {
            abort(403, 'Groupe non autorise.');
        }

        $data = $request->validate([
            'personne_id' => 'nullable|integer|exists:groupe_personnes,id',
            'nom_complet' => 'required|string|max:255',
            'telephone' => 'nullable|string|max:20',
            'fonction' => 'nullable|string|max:100',
        ]);

        if (!empty($data['personne_id'])) {
            $personne = GroupePersonne::where('id', $data['personne_id'])
                ->where('groupe_id', $groupe->id)
                ->firstOrFail();

            $personne->update([
                'nom_complet' => $data['nom_complet'],
                'telephone' => $data['telephone'] ?? null,
                'fonction' => $data['fonction'] ?? null,
            ]);

            return redirect()->route('caserne.groupes.personnes.create', $groupe)
                ->with('success', 'Personne modifiee avec succes.');
        }

        GroupePersonne::create([
            'groupe_id' => $groupe->id,
            'nom_complet' => $data['nom_complet'],
            'telephone' => $data['telephone'] ?? null,
            'fonction' => $data['fonction'] ?? null,
        ]);

        return redirect()->route('caserne.groupes.personnes.create', $groupe)
            ->with('success', 'Personne ajoutée au groupe avec succès.');
    }

    public function archivePersonne(User $groupe, GroupePersonne $personne)
    {
        $caserne = Auth::user();

        if ($groupe->role !== 'groupe' || $groupe->caserne_id !== $caserne->id || $personne->groupe_id !== $groupe->id) {
            abort(403, 'Action non autorisee.');
        }

        if ($personne->archived_at) {
            return redirect()->route('caserne.groupes.personnes.create', $groupe)
                ->with('success', 'Cette personne est deja archivee.');
        }

        $personne->update([
            'archived_at' => now(),
        ]);

        return redirect()->route('caserne.groupes.personnes.create', $groupe)
            ->with('success', 'Personne archivee avec succes.');
    }

    public function destroyPersonne(User $groupe, GroupePersonne $personne)
    {
        $caserne = Auth::user();

        if ($groupe->role !== 'groupe' || $groupe->caserne_id !== $caserne->id || $personne->groupe_id !== $groupe->id) {
            abort(403, 'Action non autorisee.');
        }

        $personne->delete();

        return redirect()->route('caserne.groupes.personnes.create', $groupe)
            ->with('success', 'Personne supprimee avec succes.');
    }

    public function store(Request $request)
    {
        $caserne = Auth::user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'telephone' => 'required|string|max:20',
        ]);

        $otp = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $groupe = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'password' => Hash::make(Str::random(24)),
            'role' => 'groupe',
            'status' => 'pending',
            'otp_code' => $otp,
            'caserne_id' => $caserne->id,
        ]);

        Mail::to($groupe->email)->send(new GroupeOtpMail($groupe, $otp));

        return redirect()->route('caserne.groupes.index')->with('success', 'Le groupe a été créé. Un email de configuration du mot de passe a été envoyé.');
    }

    public function showSinistre(Sinistre $sinistre)
    {
        $groupe = Auth::user();
        $caserne = $groupe->caserneParent;

        // Vérifier si le groupe est autorisé à voir ce sinistre
        $isAuthorized = $sinistre->assigned_caserne_id === $groupe->id ||
            ($caserne && $sinistre->casernes()->where('user_id', $caserne->id)->exists());

        if (!$isAuthorized) {
            abort(403, 'Vous n\'êtes pas autorisé à consulter cet incident.');
        }

        return view('groupe.sinistre.show', compact('sinistre', 'groupe', 'caserne'));
    }

    public function etatDesLieuxCreate(Sinistre $sinistre)
    {
        $groupe = Auth::user();
        $caserne = $groupe->caserneParent;

        if ($sinistre->assigned_caserne_id !== $groupe->id) {
            abort(403, 'Vous n\'etes pas autorise a faire l\'etat des lieux de cet incident.');
        }

        // Récupérer les autres sinistres actifs (en attente ou en cours)
        // liés à la caserne parente pour permettre le regroupement (doublons)
        $autresSinistres = Sinistre::where('id', '!=', $sinistre->id)
            ->whereIn('status', ['en_attente', 'en_cours'])
            ->where(function($query) use ($caserne) {
                $query->whereHas('casernes', function($q) use ($caserne) {
                    $q->where('users.id', $caserne->id);
                })->orWhere('assigned_caserne_id', $caserne->id);
            })
            ->latest()
            ->get();

        return view('groupe.interventions.etat-des-lieux', compact('sinistre', 'groupe', 'caserne', 'autresSinistres'));
    }

    public function etatDesLieuxStore(Request $request, Sinistre $sinistre)
    {
        $groupe = Auth::user();

        if ($sinistre->assigned_caserne_id !== $groupe->id) {
            abort(403, 'Vous n\'etes pas autorise a mettre a jour cet incident.');
        }

        $data = $request->validate([
            'rapport_intervention' => 'required|string|min:10',
            'nb_morts' => 'nullable|integer|min:0',
            'nb_blesses' => 'nullable|integer|min:0',
            'nb_evacues' => 'nullable|integer|min:0',
            'etat_des_lieux_documents' => 'nullable|array',
            'etat_des_lieux_documents.*' => 'file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'merged_sinistres' => 'nullable|array',
            'merged_sinistres.*' => 'exists:sinistres,id',
        ]);

        $existingDocuments = is_array($sinistre->etat_des_lieux_documents)
            ? $sinistre->etat_des_lieux_documents
            : [];

        $uploadedDocuments = [];
        if ($request->hasFile('etat_des_lieux_documents')) {
            foreach ($request->file('etat_des_lieux_documents') as $file) {
                if ($file) {
                    $uploadedDocuments[] = $file->store('etat-des-lieux', 'public');
                }
            }
        }

        $documentPaths = array_values(array_filter(array_merge($existingDocuments, $uploadedDocuments)));

        $sinistre->update([
            'rapport_intervention' => $data['rapport_intervention'],
            'nb_morts' => $data['nb_morts'] ?? 0,
            'nb_blesses' => $data['nb_blesses'] ?? 0,
            'nb_evacues' => $data['nb_evacues'] ?? 0,
            'etat_des_lieux_documents' => $documentPaths,
            'status' => 'termine',
            'date_cloture' => now(),
        ]);

        // Marquer les sinistres fusionnés (doublons) comme terminés
        if (!empty($data['merged_sinistres'])) {
            Sinistre::whereIn('id', $data['merged_sinistres'])->update([
                'status' => 'termine',
                'date_cloture' => now(),
                'rapport_intervention' => "[DOUBLON] Cet incident a été traité lors de l'intervention #" . ($sinistre->reference ?? $sinistre->id),
            ]);
        }

        return redirect()->route('caserne.groupe.interventions.index')
            ->with('success', 'Etat des lieux enregistré avec succès. ' . (isset($data['merged_sinistres']) ? count($data['merged_sinistres']) . ' doublons clôturés.' : ''));
    }
}
