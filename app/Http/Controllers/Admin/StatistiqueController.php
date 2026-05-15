<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use App\Models\User;

class StatistiqueController extends Controller
{
    public function index()
    {
        $casernes = User::where('role', 'caserne')
            ->where(function ($query) {
                $query->where('status', '!=', 'archived')
                    ->orWhereNull('status');
            })
            ->withCount([
                'sinistresAssignes as sinistres_total',
            ])
            ->get()
            ->map(function ($caserne) {
                $groupIds = User::where('caserne_id', $caserne->id)->pluck('id')->push($caserne->id);

                $caserne->sinistres_non_termines = Sinistre::whereIn('assigned_caserne_id', $groupIds)
                    ->where(function($q) {
                        $q->whereNull('status')
                          ->orWhere('status', '!=', 'termine');
                    })
                    ->count();

                $caserne->sinistres_termines = Sinistre::whereIn('assigned_caserne_id', $groupIds)
                    ->where('status', 'termine')
                    ->count();
                
                $caserne->sinistres_total = $caserne->sinistres_non_termines + $caserne->sinistres_termines;

                return $caserne;
            });

        return view('admin.statistiques.index', compact('casernes'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'caserne') {
            abort(404);
        }

        $groupIds = User::where('caserne_id', $user->id)->pluck('id')->push($user->id);

        $totalSinistres = Sinistre::whereIn('assigned_caserne_id', $groupIds)->count();
        $enAttente = Sinistre::whereIn('assigned_caserne_id', $groupIds)->where('status', 'en_attente')->count();
        $enCours = Sinistre::whereIn('assigned_caserne_id', $groupIds)->where('status', 'en_cours')->count();
        $termines = Sinistre::whereIn('assigned_caserne_id', $groupIds)->where('status', 'termine')->count();

        $nbMorts = Sinistre::whereIn('assigned_caserne_id', $groupIds)->sum('nb_morts');
        $nbBlesses = Sinistre::whereIn('assigned_caserne_id', $groupIds)->sum('nb_blesses');
        $nbEvacues = Sinistre::whereIn('assigned_caserne_id', $groupIds)->sum('nb_evacues');

        $latestSinistres = Sinistre::whereIn('assigned_caserne_id', $groupIds)
            ->latest()
            ->take(10)
            ->get();

        return view('admin.statistiques.show', compact(
            'user',
            'totalSinistres',
            'enAttente',
            'enCours',
            'termines',
            'nbMorts',
            'nbBlesses',
            'nbEvacues',
            'latestSinistres'
        ));
    }
}
