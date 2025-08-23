<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_site',
        'canal',
        'cell2G',
        'cell3G',
        'cell4G',
        'nodeName',
        'ip3G',
        'ip4G',
        'rnc_id',
        'bsc_id',
        'type_site_id',
        'zone_maintenance_id',
        'region_id'
    ];

    // Relation many-to-many avec Technologie
    public function technologies()
    {
        return $this->belongsToMany(Technologie::class, 'site_technologie');
    }

    // Relation avec RNC
    public function rnc()
    {
        return $this->belongsTo(Rnc::class);
    }

    // Relation avec BSC
    public function bsc()
    {
        return $this->belongsTo(Bsc::class);
    }

    // Relation avec TypeSite
    public function typeSite()
    {
        return $this->belongsTo(TypeSite::class, 'type_site_id');
    }

    // Relation avec ZoneMaintenance
    public function zoneMaintenance()
    {
        return $this->belongsTo(ZoneMaintenance::class);
    }

    // Relation avec Region
    public function region()
    {
        return $this->belongsTo(Region::class);
    }

    // Relation many-to-many avec Incident
    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'site_incident')
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

    // Relation avec les incidents où ce site est le site principal
    public function incidentsPrincipal()
    {
        return $this->hasMany(Incident::class, 'site_id');
    }
}