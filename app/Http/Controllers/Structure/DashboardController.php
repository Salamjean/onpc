<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $structure = Auth::guard('structure')->user();
        
        $stats = [
            'total' => \App\Models\Sinistre::where('structure_id', $structure->id)->count(),
            'en_cours' => \App\Models\Sinistre::where('structure_id', $structure->id)
                ->whereIn('status', ['en_attente', 'en_cours'])
                ->count(),
            'resolus' => \App\Models\Sinistre::where('structure_id', $structure->id)
                ->whereIn('status', ['resolu', 'termine'])
                ->count(),
        ];

        $recentSinistres = \App\Models\Sinistre::where('structure_id', $structure->id)
            ->with('caserneAssignee')
            ->latest()
            ->take(5)
            ->get();

        return view('structure.dashboard', compact('structure', 'stats', 'recentSinistres'));
    }
}
