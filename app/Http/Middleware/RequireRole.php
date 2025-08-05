<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequireRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Vérifier le rôle requis
        if ($user->role !== $role && $user->role !== 'superadmin') {
            abort(403, 'Accès non autorisé !');
            // abort(403, 'Accès non autorisé. Rôle requis : ' . $role);
        }

        return $next($request);
    }
}
