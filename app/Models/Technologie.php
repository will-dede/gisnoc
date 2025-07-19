<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technologie extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_technologie'
    ];

    // Relation many-to-many avec Site (une technologie peut être utilisée pour plusieurs sites)
    public function sites()
    {
        return $this->belongsToMany(Site::class, 'site_technologie');
    }

    // Relation one-to-many avec Frequence (une technologie peut avoir plusieurs fréquences)
    public function frequences()
    {
        return $this->hasMany(Frequence::class);
    }
} 