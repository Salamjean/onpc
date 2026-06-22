<?php

namespace App\Http\Controllers\Api\Groupe;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class GroupeAuthApiController extends Controller
{
    /**
     * Connexion d'un groupe et émission d'un token Sanctum
     * POST /api/groupe/login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)
                    ->where('role', 'groupe')
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants invalides ou compte non autorisé.',
            ], 401);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Votre compte groupe n\'est pas encore activé. Veuillez configurer votre mot de passe via le lien reçu par email.',
            ], 403);
        }

        // Révoquer les anciens tokens et en créer un nouveau
        $user->tokens()->delete();
        $token = $user->createToken('groupe-mobile-token')->plainTextToken;

        // Charger la caserne parente
        $caserne = $user->caserneParent;

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie.',
            'token'   => $token,
            'groupe'  => [
                'id'       => $user->id,
                'name'     => $user->name,
                'email'    => $user->email,
                'telephone' => $user->telephone,
                'status'   => $user->status,
                'caserne'  => $caserne ? [
                    'id'      => $caserne->id,
                    'name'    => $caserne->name,
                    'contact' => $caserne->telephone,
                    'adresse' => $caserne->adresse,
                ] : null,
            ],
        ], 200);
    }

    /**
     * Déconnexion (révocation du token courant)
     * POST /api/groupe/logout
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie.',
        ], 200);
    }

    /**
     * Récupérer le profil du groupe connecté
     * GET /api/groupe/profil
     */
    public function profil(Request $request)
    {
        $groupe = $request->user();
        $caserne = $groupe->caserneParent;

        return response()->json([
            'success' => true,
            'groupe'  => [
                'id'        => $groupe->id,
                'name'      => $groupe->name,
                'email'     => $groupe->email,
                'telephone' => $groupe->telephone,
                'caserne'   => $caserne ? [
                    'id'      => $caserne->id,
                    'name'    => $caserne->name,
                    'contact' => $caserne->telephone,
                    'adresse' => $caserne->adresse,
                ] : null,
            ],
        ], 200);
    }
}
