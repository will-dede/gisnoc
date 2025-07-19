<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequence extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_freq',
        'technologie_id'
    ];

    // Relation avec Technologie (une fréquence appartient à une technologie)
    public function technologie()
    {
        return $this->belongsTo(Technologie::class, 'technologie_id');
    }

    // Relation one-to-many avec Secteur (une fréquence peut avoir plusieurs secteurs)
    public function secteurs()
    {
        return $this->hasMany(Secteur::class);
//        return $this->hasMany(Secteur::class, 'frequence_id');
    }
} 