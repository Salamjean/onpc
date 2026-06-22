<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Vérifie que l'utilisateur authentifié via Sanctum est bien un groupe.
 * Utilisé sur les routes API /api/groupe/* protégées.
 */
class GroupeApiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== 'groupe') {
            return response()->json([
                'success' => false,
                'message' => 'Accès réservé aux groupes d\'intervention.',
            ], 403);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Ce compte groupe n\'est pas activé.',
            ], 403);
        }

        return $next($request);
    }
}
