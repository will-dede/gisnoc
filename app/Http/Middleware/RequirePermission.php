<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RequirePermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Vérifier si l'utilisateur est connecté
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();
        
        // Définir les permissions par rôle
        $permissions = [
            'user' => [
                'sites.view',
                'incidents.view',
                'incidents.create',
                'incidents.edit',
                'incidents.delete',
            ],
            'admin' => [
                // Permissions de lecture uniquement pour les informations opérationnelles
                'regions.view',
                'secteurs.view',
                'techniciens.view',
                'mecaniciens.view',
                'frequences.view',
                'typesite.view',
                'typealarme.view',
                'technologies.view',
                'bscs.view',
                'rncs.view',
                'zonemaintenance.view',
                // Permissions complètes pour les sites et incidents
                'sites.view',
                'sites.create',
                'sites.edit',
                'sites.delete',
                'incidents.view',
                'incidents.create',
                'incidents.edit',
                'incidents.delete',
            ],
            'superadmin' => [
                // Toutes les permissions sauf créer/modifier/supprimer les incidents
                'users.view',
                'users.create',
                'users.edit',
                'users.delete',
                'regions.view',
                'regions.create',
                'regions.edit',
                'regions.delete',
                'secteurs.view',
                'secteurs.create',
                'secteurs.edit',
                'secteurs.delete',
                'techniciens.view',
                'techniciens.create',
                'techniciens.edit',
                'techniciens.delete',
                'mecaniciens.view',
                'mecaniciens.create',
                'mecaniciens.edit',
                'mecaniciens.delete',
                'frequences.view',
                'frequences.create',
                'frequences.edit',
                'frequences.delete',
                'typesite.view',
                'typesite.create',
                'typesite.edit',
                'typesite.delete',
                'typealarme.view',
                'typealarme.create',
                'typealarme.edit',
                'typealarme.delete',
                'technologies.view',
                'technologies.create',
                'technologies.edit',
                'technologies.delete',
                'sites.view',
                'sites.create',
                'sites.edit',
                'sites.delete',
                'bscs.view',
                'bscs.create',
                'bscs.edit',
                'bscs.delete',
                'rncs.view',
                'rncs.create',
                'rncs.edit',
                'rncs.delete',
                'zonemaintenance.view',
                'zonemaintenance.create',
                'zonemaintenance.edit',
                'zonemaintenance.delete',
                'incidents.view',
                // Superadmin ne peut pas créer/modifier/supprimer les incidents
            ],
        ];

        // Superadmin a toutes les permissions sauf celles explicitement exclues
        if ($user->role === 'superadmin') {
            // Vérifier si la permission est explicitement exclue pour superadmin
            $excludedPermissions = [
                'incidents.create',
                'incidents.edit', 
                'incidents.delete',
            ];
            
            if (in_array($permission, $excludedPermissions)) {
                abort(403, 'Accès non autorisé !');
            }
            
            return $next($request);
        }

        // Vérifier si l'utilisateur a la permission demandée
        if (!in_array($permission, $permissions[$user->role] ?? [])) {
            abort(403, 'Accès non autorisé !');
        }

        return $next($request);
    }
}
