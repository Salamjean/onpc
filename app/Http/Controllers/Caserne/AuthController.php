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
                // Redirection vers le tableau de bord de la caserne (à créer plus tard)
                return redirect()->intended('/caserne/dashboard');
            }

            // Si ce n'est pas une caserne, on déconnecte
            \Illuminate\Support\Facades\Auth::logout();
            return back()->withErrors(['email' => 'Accès réservé aux casernes.'])->onlyInput('email');
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
}
