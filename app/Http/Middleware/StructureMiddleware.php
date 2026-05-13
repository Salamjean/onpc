<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StructureMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::guard('structure')->check()) {
            $structure = Auth::guard('structure')->user();
            if ($structure && $structure->status === 'inactive') {
                Auth::guard('structure')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return redirect()->route('structure.auth.login')->with('error', 'Votre compte structure est bloqué.');
            }

            return $next($request);
        }

        return redirect()->route('structure.auth.login')->with('error', 'Veuillez vous connecter pour accéder à cet espace.');
    }
}
