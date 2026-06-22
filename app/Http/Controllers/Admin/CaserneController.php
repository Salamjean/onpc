<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CaserneController extends Controller
{
    public function index()
    {
        // On récupère uniquement les casernes actives (non archivées)
        $casernes = User::where('role', 'caserne')
                        ->where(function($query) {
                            $query->where('status', '!=', 'archived')
                                  ->orWhereNull('status');
                        })
                        ->get();
        return view('admin.caserne.index', compact('casernes'));
    }

    public function archived()
    {
        // Récupère uniquement les casernes archivées
        $casernes = User::where('role', 'caserne')->where('status', 'archived')->get();
        return view('admin.caserne.archived', compact('casernes'));
    }

    public function create()
    {
        return view('admin.caserne.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'telephone' => 'required|string|max:20',
            'commune' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Vérification anti-doublon (même nom ET même localisation)
        $exists = User::where('role', 'caserne')
            ->where('name', $request->name)
            ->where('latitude', $request->latitude)
            ->where('longitude', $request->longitude)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'name' => 'Une caserne avec ce nom et cette localisation exacte existe déjà.',
                'adresse' => 'Cette adresse est déjà utilisée pour cette même caserne.'
            ]);
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('casernes', 'public');
        }

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        $caserne = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make(\Illuminate\Support\Str::random(16)),
            'role' => 'caserne',
            'status' => 'active',
            'telephone' => $request->telephone,
            'commune' => $request->commune,
            'adresse' => $request->adresse,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'logo' => $logoPath,
            'otp_code' => $otp,
        ]);

        \Illuminate\Support\Facades\Mail::to($caserne->email)->send(new \App\Mail\CaserneOtpMail($caserne, $otp));

        return redirect()->route('admin.caserne.index')->with('success', 'La caserne a été ajoutée avec succès. Un email de configuration a été envoyé.');
    }

    public function show(User $user)
    {
        if ($user->role !== 'caserne') abort(404);
        return view('admin.caserne.show', compact('user'));
    }

    public function edit(User $user)
    {
        if ($user->role !== 'caserne') abort(404);
        return view('admin.caserne.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role !== 'caserne') abort(404);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'telephone' => 'required|string|max:20',
            'commune' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'nullable|string',
        ]);

        // Vérification anti-doublon lors de la mise à jour
        $exists = User::where('role', 'caserne')
            ->where('id', '!=', $user->id)
            ->where('name', $request->name)
            ->where('latitude', $request->latitude)
            ->where('longitude', $request->longitude)
            ->exists();

        if ($exists) {
            return back()->withInput()->withErrors([
                'name' => 'Une autre caserne avec ce nom et cette localisation exacte existe déjà.'
            ]);
        }

        $data = $request->only(['name', 'email', 'telephone', 'commune', 'adresse', 'latitude', 'longitude', 'status']);

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('casernes', 'public');
            $data['logo'] = $logoPath;
        }

        $user->update($data);

        return redirect()->route('admin.caserne.index')->with('success', 'Opération réussie.');
    }

    public function destroy(User $user)
    {
        if ($user->role !== 'caserne') abort(404);
        
        if ($user->status === 'archived') {
            // Suppression définitive si déjà archivé
            $user->delete();
            return redirect()->route('admin.caserne.archived')->with('success', 'La caserne a été supprimée définitivement.');
        }

        // Sinon simple archivage
        $user->update(['status' => 'archived']);
        return redirect()->route('admin.caserne.index')->with('success', 'La caserne a été archivée avec succès.');
    }
}
