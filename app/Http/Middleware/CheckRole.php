<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role, string $permission = null): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Vérifier le rôle
        if ($user->role !== $role && $user->role !== 'superadmin') {
            abort(403, 'Accès non autorisé.');
        }

        // Si une permission spécifique est demandée
        if ($permission) {
            // Logique pour vérifier les permissions spécifiques
            if (!$this->hasPermission($user, $permission)) {
                abort(403, 'Permission insuffisante.');
            }
        }

        return $next($request);
    }

    /**
     * Vérifier si l'utilisateur a une permission spécifique
     */
    private function hasPermission($user, $permission): bool
    {
        // Définir les permissions par rôle
        $permissions = [
            'user' => [
                'sites.view',
                'incidents.view',
                'incidents.create',
                'incidents.edit',
                'incidents.delete',
            ],
            'noc_engineer' => [
                'sites.view',
                'sites.create',
                'sites.edit',
                'sites.delete',
                'bscs.view',
                'rncs.view',
                'techniciens.view',
                'techniciens.create',
                'techniciens.edit',
                'techniciens.delete',
                'mecaniciens.view',
                'mecaniciens.create',
                'mecaniciens.edit',
                'mecaniciens.delete',
                'regions.view',
                'regions.create',
                'regions.edit',
                'regions.delete',
                'technologies.view',
                'technologies.create',
                'technologies.edit',
                'technologies.delete',
                'frequences.view',
                'frequences.create',
                'frequences.edit',
                'frequences.delete',
                'secteurs.view',
                'secteurs.create',
                'secteurs.edit',
                'secteurs.delete',
                'typesite.view',
                'typesite.create',
                'typesite.edit',
                'typesite.delete',
                'typealarme.view',
                'typealarme.create',
                'typealarme.edit',
                'typealarme.delete',
                'zonemaintenance.view',
                'zonemaintenance.create',
                'zonemaintenance.edit',
                'zonemaintenance.delete',
                'incidents.view',
                'incidents.create',
                'incidents.edit',
                'incidents.delete',
            ],
            'superadmin' => [
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
                'sites.view',
                'sites.create',
                'sites.edit',
                'sites.delete',
                'bscs.view',
                'rncs.view',
                'techniciens.view',
                'techniciens.create',
                'techniciens.edit',
                'techniciens.delete',
                'mecaniciens.view',
                'mecaniciens.create',
                'mecaniciens.edit',
                'mecaniciens.delete',
                'regions.view',
                'regions.create',
                'regions.edit',
                'regions.delete',
                'technologies.view',
                'technologies.create',
                'technologies.edit',
                'technologies.delete',
                'frequences.view',
                'frequences.create',
                'frequences.edit',
                'frequences.delete',
                'secteurs.view',
                'secteurs.create',
                'secteurs.edit',
                'secteurs.delete',
                'typesite.view',
                'typesite.create',
                'typesite.edit',
                'typesite.delete',
                'typealarme.view',
                'typealarme.create',
                'typealarme.edit',
                'typealarme.delete',
                'zonemaintenance.view',
                'zonemaintenance.create',
                'zonemaintenance.edit',
                'zonemaintenance.delete',
                'incidents.view',
                // Superadmin ne peut pas créer/modifier/supprimer les incidents
            ],
        ];

        // Superadmin a toutes les permissions
        if ($user->role === 'superadmin') {
            return true;
        }

        // Vérifier si l'utilisateur a la permission demandée
        return in_array($permission, $permissions[$user->role] ?? []);
    }
}
