<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_region'
    ];

    //Relation avec la table Site (une région peut avoir plusieurs sites)
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
} 