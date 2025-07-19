<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mecanicien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_mecano',
        'prenom_mecano',
        'tel_mecano',
        'est_proprietaire',
        'zone_maintenance_id'
    ];

    // Relation avec ZoneMaintenance (un mécanicien appartient à une zone de maintenance)
    public function zoneMaintenance()
    {
        return $this->belongsTo(ZoneMaintenance::class, 'zone_maintenance_id');
    }

    // Relation one-to-many avec Incident (un mécanicien peut avoir plusieurs incidents)
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
} 