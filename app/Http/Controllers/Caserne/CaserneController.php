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

        $sinistresScopes = Sinistre::whereHas('casernes', function ($query) use ($caserne) {
            $query->where('users.id', $caserne->id);
        });

        $sinistresEnAttente = (clone $sinistresScopes)->where('status', 'en_attente')->count();
        $sinistresEnCours = (clone $sinistresScopes)->where('status', 'en_cours')->count();
        $sinistresTermines = (clone $sinistresScopes)->where('status', 'termine')->count();
        $sinistresZone = (clone $sinistresScopes)->whereNull('assigned_caserne_id')->count();

        $statsParStatut = [
            'En attente' => $sinistresEnAttente,
            'En cours' => $sinistresEnCours,
            'Terminé' => $sinistresTermines,
        ];

        $statsParType = (clone $sinistresScopes)->selectRaw('type_sinistre, count(*) as total')
            ->groupBy('type_sinistre')
            ->orderByDesc('total')
            ->pluck('total', 'type_sinistre');

        $dernieresDeclarations = (clone $sinistresScopes)
            ->latest()
            ->limit(2)
            ->get();

        return view('caserne.dashboard', compact(
            'sinistresEnAttente',
            'sinistresEnCours',
            'sinistresTermines',
            'sinistresZone',
            'statsParStatut',
            'statsParType',
            'dernieresDeclarations'
        ));
    }

    public function sinistres()
    {
        $caserne = Auth::user();
        $groupIds = $caserne->groupes()->pluck('id')->push($caserne->id);

        $sinistres = Sinistre::with('caserneAssignee')
            ->where('status', '!=', 'termine')
            ->where(function ($query) use ($caserne, $groupIds) {
                $query->whereHas('casernes', function ($q) use ($caserne) {
                    $q->where('users.id', $caserne->id);
                })
                ->orWhereIn('assigned_caserne_id', $groupIds);
            })
            ->latest()
            ->paginate(12);

        return view('caserne.sinistres.index', compact('sinistres', 'caserne'));
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
        $ids = $caserne->groupes()->pluck('id')->push($caserne->id);

        $sinistres = Sinistre::with('caserneAssignee')
            ->whereIn('assigned_caserne_id', $ids)
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
        $user = Auth::user();

        // Si c'est un groupe, vérifier les permissions du groupe
        if ($user->role === 'groupe') {
            $caserne = $user->caserneParent;

            // Le groupe est autorisé s'il est assigné au sinistre OR si le sinistre appartient à sa caserne parent
            $isAuthorized = $sinistre->assigned_caserne_id === $user->id ||
                ($caserne && $sinistre->casernes()->where('user_id', $caserne->id)->exists());

            if (!$isAuthorized) {
                abort(403, 'Vous n\'êtes pas autorisé à consulter cet incident.');
            }

            return view('caserne.sinistre.show', compact('sinistre', 'caserne'));
        }

        // Si c'est une caserne
        $caserne = $user;

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
        abort(403, 'La prise en charge des sinistres est desactivee pour la caserne.');
    }
}
