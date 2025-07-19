<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secteur extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_secteur',
        'frequence_id'
    ];

    // Relation avec Frequence (un secteur appartient à une fréquence)
    public function frequence()
    {
        return $this->belongsTo(Frequence::class, 'frequence_id');
    }

    // Relation many-to-many avec Incident (un secteur peut avoir plusieurs incidents)
    public function incidents()
    {
        return $this->belongsToMany(Incident::class, 'secteur_incident');
    }
} 