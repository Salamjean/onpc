<?php

namespace App\Http\Controllers\Caserne;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CaserneController extends Controller
{
    public function dashboard()
    {
        $caserne = Auth::user();

        // 1. Sinistres assignés directement à cette caserne (depuis structure) et encore en_attente
        $sinistresAssignes = Sinistre::where('assigned_caserne_id', $caserne->id)
            ->where('status', 'en_attente')
            ->latest()
            ->get();

        // 2. Sinistres dans la zone de la caserne (via pivot) non encore assignés
        $sinistresZone = $caserne->sinistresAssignes()
            ->whereNull('assigned_caserne_id')
            ->latest()
            ->get();

        // 3. Interventions en cours (status = 'en_cours')
        $interventions = Sinistre::where('assigned_caserne_id', $caserne->id)
            ->where('status', 'en_cours')
            ->latest()
            ->get();

        // Fusionner les trois collections sans doublons
        $sinistres = $sinistresAssignes->merge($sinistresZone)->merge($interventions)->unique('id')->values();

        // Compter les interventions en cours
        $interventionsCount = $interventions->count();

        if (request()->ajax()) {
            return view('caserne.partials.sinistres_table', compact('sinistres', 'interventionsCount'));
        }

        return view('caserne.dashboard', compact('sinistres', 'interventionsCount'));
    }

    public function rapports()
    {
        $caserne = Auth::user();

        $rapports = Sinistre::where('assigned_caserne_id', $caserne->id)
            ->where('status', 'termine')
            ->whereNotNull('rapport_intervention')
            ->latest('date_cloture')
            ->paginate(12);

        return view('caserne.rapports.index', compact('rapports'));
    }

    public function historique()
    {
        $caserne = Auth::user();

        $sinistres = Sinistre::where('assigned_caserne_id', $caserne->id)
            ->where('status', 'termine')
            ->latest('date_cloture')
            ->paginate(12);

        return view('caserne.historique.index', compact('sinistres'));
    }

    public function rapport(Sinistre $sinistre)
    {
        $caserne = Auth::user();

        // Vérifier que c'est bien la caserne assignée qui fait le rapport
        if ($sinistre->assigned_caserne_id !== $caserne->id) {
            abort(403, 'Vous n\'êtes pas autorisé à rédiger ce rapport.');
        }

        return view('caserne.sinistre.rapport', compact('sinistre', 'caserne'));
    }

    public function complete(Sinistre $sinistre, Request $request)
    {
        $request->validate([
            'rapport_intervention' => 'required|string|min:10',
            'nb_morts' => 'required|integer|min:0',
            'nb_blesses' => 'required|integer|min:0',
            'nb_evacues' => 'required|integer|min:0',
        ]);

        $sinistre->update([
            'rapport_intervention' => $request->rapport_intervention,
            'nb_morts' => $request->nb_morts,
            'nb_blesses' => $request->nb_blesses,
            'nb_evacues' => $request->nb_evacues,
            'status' => 'termine',
            'date_cloture' => now(),
        ]);

        return redirect()->route('caserne.dashboard')->with('success', 'Intervention terminée et rapport enregistré avec succès.');
    }

    public function show(Sinistre $sinistre)
    {
        $caserne = Auth::user();

        // Vérifier si la caserne est autorisée à voir ce sinistre
        // (Elle doit être la caserne la plus proche OR la caserne assignée)
        $isAuthorized = $sinistre->casernes()->where('user_id', $caserne->id)->exists() ||
            $sinistre->assigned_caserne_id === $caserne->id;

        if (!$isAuthorized) {
            abort(403, 'Vous n\'êtes pas autorisé à consulter cet incident.');
        }

        return view('caserne.sinistre.show', compact('sinistre', 'caserne'));
    }

    public function claim(Sinistre $sinistre)
    {
        $caserne = Auth::user();

        // Vérifier si le sinistre est déjà pris par quelqu'un d'autre
        if ($sinistre->assigned_caserne_id && $sinistre->assigned_caserne_id !== $caserne->id) {
            return back()->with('error', 'Ce sinistre a déjà été récupéré par une autre caserne.');
        }

        // Assigner à la caserne actuelle
        $sinistre->update([
            'assigned_caserne_id' => $caserne->id,
            'status' => 'en_cours'
        ]);

        // Envoi immédiat du SMS de notification au déclarant
        $ref = $sinistre->reference ?? "#SN-{$sinistre->id}";
        $message = "Urgence ONPC - {$ref}: La caserne {$caserne->name} est actuellement en route. Merci de nous avoir alertés.";

        SmsService::send($sinistre->contact, $message);

        return back()->with('success', 'Intervention démarrée ! Les secours sont en route.');
    }
}
