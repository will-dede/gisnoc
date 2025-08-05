<?php

namespace App\Helpers;

class PermissionHelper
{
    /**
     * Définir les permissions par rôle
     */
    private static function getPermissions(): array
    {
        return [
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
    }

    /**
     * Vérifier si l'utilisateur a une permission spécifique
     */
    public static function hasPermission(string $permission): bool
    {
        if (!auth()->check()) {
            return false;
        }

        $user = auth()->user();
        $permissions = self::getPermissions();

        // Superadmin a toutes les permissions sauf celles explicitement exclues
        if ($user->role === 'superadmin') {
            $excludedPermissions = [
                'incidents.create',
                'incidents.edit', 
                'incidents.delete',
            ];
            
            return !in_array($permission, $excludedPermissions);
        }

        return in_array($permission, $permissions[$user->role] ?? []);
    }

    /**
     * Vérifier si l'utilisateur peut créer
     */
    public static function canCreate(string $resource): bool
    {
        return self::hasPermission($resource . '.create');
    }

    /**
     * Vérifier si l'utilisateur peut éditer
     */
    public static function canEdit(string $resource): bool
    {
        return self::hasPermission($resource . '.edit');
    }

    /**
     * Vérifier si l'utilisateur peut supprimer
     */
    public static function canDelete(string $resource): bool
    {
        return self::hasPermission($resource . '.delete');
    }

    /**
     * Vérifier si l'utilisateur peut voir
     */
    public static function canView(string $resource): bool
    {
        return self::hasPermission($resource . '.view');
    }
} 