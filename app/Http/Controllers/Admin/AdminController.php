<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use App\Models\Structure;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $totalSinistres   = Sinistre::count();
        $enAttente        = Sinistre::where('status', 'en_attente')->count();
        $enCours          = Sinistre::where('status', 'en_cours')->count();
        $resolus          = Sinistre::whereIn('status', ['resolu', 'termine'])->count();
        $totalStructures  = Structure::count();
        $structuresActive = Structure::where('status', 'active')->count();

        // Dernières déclarations non traitées (en_attente)
        $sinistresNonTraites = Sinistre::with('structure')
            ->where('status', 'en_attente')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.dashboard', compact(
            'totalSinistres',
            'enAttente',
            'enCours',
            'resolus',
            'totalStructures',
            'structuresActive',
            'sinistresNonTraites'
        ));
    }
}
