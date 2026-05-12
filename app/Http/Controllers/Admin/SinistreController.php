<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sinistre;
use App\Models\User;
use Illuminate\Http\Request;

class SinistreController extends Controller
{
    public function index(Request $request)
    {
        $casernes = User::where('role', 'caserne')
            ->where(function ($query) {
                $query->where('status', '!=', 'archived')
                    ->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $query = Sinistre::with('caserneAssignee')
            ->where(function ($q) {
                $q->whereNull('status')
                    ->orWhere('status', '!=', 'termine');
            })
            ->latest();

        // Filtre par type
        if ($request->filled('type')) {
            $query->where('type_sinistre', $request->type);
        }

        // Filtre par statut
        if ($request->filled('status') && $request->status !== 'termine') {
            $query->where('status', $request->status);
        }

        // Filtre par date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('caserne_id')) {
            $query->where('assigned_caserne_id', $request->caserne_id);
        }

        $sinistres = $query->paginate(15);

        return view('admin.sinistre.index', compact('sinistres', 'casernes'));
    }

    public function historique(Request $request)
    {
        $casernes = User::where('role', 'caserne')
            ->where(function ($query) {
                $query->where('status', '!=', 'archived')
                    ->orWhereNull('status');
            })
            ->orderBy('name')
            ->get();

        $query = Sinistre::with('caserneAssignee')
            ->where('status', 'termine')
            ->latest();

        if ($request->filled('type')) {
            $query->where('type_sinistre', $request->type);
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        if ($request->filled('caserne_id')) {
            $query->where('assigned_caserne_id', $request->caserne_id);
        }

        $sinistres = $query->paginate(15);

        return view('admin.sinistre.historique', compact('sinistres', 'casernes'));
    }

    public function show(Sinistre $sinistre)
    {
        return view('admin.sinistre.show', compact('sinistre'));
    }
}
