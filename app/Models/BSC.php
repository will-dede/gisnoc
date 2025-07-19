<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bsc extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_bsc'
    ];

    //Relation avec la table Site (une BSC peut avoir plusieurs sites)
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
} 