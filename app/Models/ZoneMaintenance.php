<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZoneMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_zone'
    ];

    // Relation one-to-many avec Technicien
    public function techniciens()
    {
        return $this->hasMany(Technicien::class);
    }

    // Relation one-to-many avec Site
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
} 