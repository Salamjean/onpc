<?php

namespace App\Http\Controllers\Structure;

use App\Http\Controllers\Controller;
use App\Models\Structure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de configuration du mot de passe
     */
    public function showSetupForm(Request $request)
    {
        $email = $request->email;
        return view('structure.auth.setup-password', compact('email'));
    }

    /**
     * Affiche le formulaire de connexion de la structure
     */
    public function showLoginForm()
    {
        return view('structure.auth.login');
    }

    /**
     * Gère la connexion de la structure
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $structure = Structure::where('email', $credentials['email'])->first();
        if ($structure && $structure->status === 'inactive') {
            return back()->withErrors(['email' => 'Votre compte structure est bloqué. Veuillez contacter l\'administrateur.'])->onlyInput('email');
        }

        if (Auth::guard('structure')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('structure.dashboard');
        }

        return back()->withErrors(['email' => 'Identifiants invalides.'])->onlyInput('email');
    }

    /**
     * Enregistre le nouveau mot de passe après vérification de l'OTP
     */
    public function setupPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:structures,email',
            'otp_code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $structure = Structure::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->first();

        if (!$structure) {
            return back()->withErrors(['otp_code' => 'Le code OTP ou l\'email est invalide.'])->withInput();
        }

        if ($structure->status === 'inactive') {
            return back()->withErrors(['email' => 'Ce compte structure est bloqué.'])->withInput();
        }

        // Mise à jour du mot de passe, passage en statut actif et suppression de l'OTP
        $structure->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'status' => 'active',
        ]);

        return redirect()->route('structure.auth.login')->with('success', 'Votre compte a été activé avec succès. Vous pouvez maintenant vous connecter.');
    }

    /**
     * Déconnexion
     */
    public function logout(Request $request)
    {
        Auth::guard('structure')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('structure.auth.login');
    }

    /**
     * Affiche le formulaire de demande de réinitialisation
     */
    public function showForgotPasswordForm()
    {
        return view('structure.auth.forgot-password');
    }

    /**
     * Envoie le code OTP de réinitialisation
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:structures,email']);

        $structure = Structure::where('email', $request->email)->first();

        // Génération d'un code OTP à 6 chiffres
        $otp = rand(100000, 999999);
        $structure->update(['otp_code' => $otp]);

        // Envoi de l'email
        \Illuminate\Support\Facades\Mail::to($structure->email)->send(new \App\Mail\OtpStructureMail($otp));

        return redirect()->route('structure.auth.setup', ['email' => $request->email])
            ->with('success', 'Un code de vérification a été envoyé à votre adresse email.');
    }

    /**
     * Affiche le formulaire de changement de mot de passe (via OTP)
     */
    public function showResetPasswordForm(Request $request)
    {
        return view('structure.auth.setup-password', ['email' => $request->email]);
    }
}
