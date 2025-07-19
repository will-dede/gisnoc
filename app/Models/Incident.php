<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_debut_incident',
        'date_fin_incident',
        'date_contact_technicien',
        'date_arrivee_sur_site',
        'intervenant',
        'causes_incident',
        'actions_effectuees',
        'observation',
        'notes',
        'technicien_id',
        'type_alarme_id',
        'site_id'
        // 'user_id'
    ];

    protected $casts = [
        'date_debut_incident' => 'datetime',
        'date_fin_incident' => 'datetime',
    ];

    // Relation avec Technicien (un incident est lié à un technicien)
    public function technicien()
    {
        return $this->belongsTo(Technicien::class, 'technicien_id');
    }

    // Relation avec TypeAlarme (un incident est lié à un type d'alarme)
    public function typeAlarme()
    {
        return $this->belongsTo(TypeAlarme::class, 'type_alarme_id');
    }

    // Relation avec User (un incident est lié à un utilisateur)
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // Relation avec le site principal
    public function site()
    {
        return $this->belongsTo(Site::class, 'site_id');
    }

    // Relation many-to-many avec Site (autres sites impactés)
    public function sites()
    {
        return $this->belongsToMany(Site::class, 'site_incident')
            ->withPivot([
                'date_debut_incident',
                'date_fin_incident',
                'date_arrivee_sur_site',
                'intervenant',
                'causes_incident',
                'actions_effectuees',
                'observation',
                'notes',
                'technicien_id',
                'type_alarme_id'
            ])
            ->withTimestamps();
    }

    // Relation many-to-many avec Secteur (un incident peut concerner plusieurs secteurs)
    public function secteurs()
    {
        return $this->belongsToMany(Secteur::class, 'secteur_incident');
    }
}