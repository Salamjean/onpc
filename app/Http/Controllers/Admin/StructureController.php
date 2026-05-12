<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Structure;
use App\Mail\StructureOtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class StructureController extends Controller
{
    public function index()
    {
        $structures = Structure::latest()->paginate(15);
        return view('admin.structure.index', compact('structures'));
    }

    public function create()
    {
        return view('admin.structure.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'required|email|unique:structures,email',
            'adresse' => 'required|string|max:255',
            'commune' => 'required|string|max:100',
            'ville' => 'required|string|max:100',
        ]);

        $otp = rand(100000, 999999);

        $structure = Structure::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'contact' => $request->contact,
            'adresse' => $request->adresse,
            'commune' => $request->commune,
            'ville' => $request->ville,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'status' => 'pending',
            'password' => Hash::make(Str::random(12)),
            'otp_code' => $otp,
        ]);

        // Envoi du mail avec l'OTP
        Mail::to($structure->email)->send(new StructureOtpMail($structure, $otp));

        return redirect()->route('admin.structure.index')->with('success', 'Structure enregistrée avec succès. Un mail de configuration a été envoyé.');
    }

    public function edit(Structure $structure)
    {
        return view('admin.structure.edit', compact('structure'));
    }

    public function update(Request $request, Structure $structure)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'contact' => 'required|string|max:20',
            'email' => 'required|email|unique:structures,email,' . $structure->id,
            'adresse' => 'required|string|max:255',
            'commune' => 'required|string|max:100',
            'ville' => 'required|string|max:100',
        ]);

        $structure->update($request->all());

        return redirect()->route('admin.structure.index')->with('success', 'Structure mise à jour avec succès.');
    }

    public function resendOtp(Structure $structure)
    {
        if ($structure->status !== 'pending') {
            return back()->with('error', 'Cette structure est déjà active.');
        }

        $otp = rand(100000, 999999);
        $structure->update(['otp_code' => $otp]);

        Mail::to($structure->email)->send(new StructureOtpMail($structure, $otp));

        return back()->with('success', 'Le mail de configuration a été renvoyé avec succès.');
    }

    public function destroy(Structure $structure)
    {
        $structure->delete();
        return back()->with('success', 'Structure supprimée avec succès.');
    }
}
