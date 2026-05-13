<?php

namespace App\Http\Controllers\Caserne;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Affiche le formulaire de configuration du mot de passe
     */
    public function showSetupForm(Request $request)
    {
        $email = $request->email;
        return view('caserne.auth.setup-password', compact('email'));
    }

    /**
     * Affiche le formulaire de configuration du mot de passe pour un groupe
     */
    public function showGroupeSetupForm(Request $request)
    {
        $email = $request->email;
        return view('caserne.auth.setup-password-groupe', compact('email'));
    }

    /**
     * Affiche le formulaire de connexion de la caserne
     */
    public function showLoginForm()
    {
        return view('caserne.auth.login');
    }

    /**
     * Gère la connexion de la caserne
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (\Illuminate\Support\Facades\Auth::attempt($credentials)) {
            $user = \Illuminate\Support\Facades\Auth::user();

            if ($user->role === 'caserne') {
                $request->session()->regenerate();
                return redirect()->intended('/caserne/dashboard');
            }

            if ($user->role === 'groupe') {
                $request->session()->regenerate();
                return redirect()->intended('/caserne/groupe/dashboard');
            }

            // Si ce n'est pas une caserne ou un groupe, on déconnecte
            \Illuminate\Support\Facades\Auth::logout();
            return back()->withErrors(['email' => 'Accès réservé aux casernes et groupes.'])->onlyInput('email');
        }

        return back()->withErrors(['email' => 'Identifiants invalides.'])->onlyInput('email');
    }

    /**
     * Enregistre le nouveau mot de passe après vérification de l'OTP
     */
    public function setupPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->where('role', 'caserne')
            ->first();

        if (!$user) {
            return back()->withErrors(['otp_code' => 'Le code OTP ou l\'email est invalide.'])->withInput();
        }

        // Mise à jour du mot de passe et suppression de l'OTP
        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
        ]);

        return redirect()->route('caserne.auth.login')->with('success', 'Votre mot de passe a été configuré avec succès. Vous pouvez maintenant vous connecter.');
    }

    /**
     * Enregistre le mot de passe pour un groupe après vérification de l'OTP
     */
    public function setupGroupePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp_code' => 'required|string|size:6',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)
            ->where('otp_code', $request->otp_code)
            ->where('role', 'groupe')
            ->first();

        if (!$user) {
            return back()->withErrors(['otp_code' => 'Le code OTP ou l\'email est invalide.'])->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password),
            'otp_code' => null,
            'status' => 'active',
        ]);

        return redirect()->route('caserne.auth.login')->with('success', 'Mot de passe du groupe configuré avec succès. Vous pouvez maintenant vous connecter.');
    }
    /**
     * Affiche le formulaire de demande de réinitialisation
     */
    public function showForgotPasswordForm()
    {
        return view('caserne.auth.forgot-password');
    }

    /**
     * Envoie le code OTP de réinitialisation
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $user = User::where('email', $request->email)->first();

        // Génération d'un code OTP à 6 chiffres
        $otp = rand(100000, 999999);
        $user->update(['otp_code' => $otp]);

        // Envoi de l'email
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\OtpCaserneMail($otp));

        return redirect()->route('caserne.auth.setup-form', ['email' => $request->email])
            ->with('success', 'Un code de vérification a été envoyé à votre adresse email.');
    }
}
