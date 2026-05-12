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
                $caserne->sinistres_non_termines = Sinistre::where('assigned_caserne_id', $caserne->id)
                    ->where('status', '!=', 'termine')
                    ->count();

                $caserne->sinistres_termines = Sinistre::where('assigned_caserne_id', $caserne->id)
                    ->where('status', 'termine')
                    ->count();

                return $caserne;
            });

        return view('admin.statistiques.index', compact('casernes'));
    }

    public function show(User $user)
    {
        if ($user->role !== 'caserne') {
            abort(404);
        }

        $totalSinistres = Sinistre::where('assigned_caserne_id', $user->id)->count();
        $enAttente = Sinistre::where('assigned_caserne_id', $user->id)->where('status', 'en_attente')->count();
        $enCours = Sinistre::where('assigned_caserne_id', $user->id)->where('status', 'en_cours')->count();
        $termines = Sinistre::where('assigned_caserne_id', $user->id)->where('status', 'termine')->count();

        $nbMorts = Sinistre::where('assigned_caserne_id', $user->id)->sum('nb_morts');
        $nbBlesses = Sinistre::where('assigned_caserne_id', $user->id)->sum('nb_blesses');
        $nbEvacues = Sinistre::where('assigned_caserne_id', $user->id)->sum('nb_evacues');

        $latestSinistres = Sinistre::where('assigned_caserne_id', $user->id)
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
