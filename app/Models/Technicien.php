<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technicien extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_tech',
        'prenom_tech',
        'tel_tech',
        'est_proprietaire',
        'zone_maintenance_id'
    ];

    // Relation avec ZoneMaintenance (un technicien appartient à une zone de maintenance)
    public function zoneMaintenance()
    {
        return $this->belongsTo(ZoneMaintenance::class, 'zone_maintenance_id');
    }

    // Relation one-to-many avec Incident (un technicien peut avoir plusieurs incidents)
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
} 