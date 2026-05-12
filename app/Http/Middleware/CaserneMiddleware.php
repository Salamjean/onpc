<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CaserneMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || Auth::user()->role !== 'caserne') {
            // Si pas connecté ou pas le rôle caserne, on redirige vers le login caserne
            return redirect()->route('caserne.auth.login')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}
