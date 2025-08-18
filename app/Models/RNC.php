<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rnc extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_rnc'
    ];

    //Relation avec la table Site (une RNC peut avoir plusieurs sites)
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
}