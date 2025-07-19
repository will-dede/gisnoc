<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeAlarme extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_type_alarme',
        'descr_type_alarme'
    ];

    // Relation one-to-many avec Incident (Un type d'alarme peut concerner plusieurs incidents)
    public function incidents()
    {
        return $this->hasMany(Incident::class);
    }
} 