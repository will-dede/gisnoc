<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeSite extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_type_site'
    ];

    // Relation one-to-many avec Site (un node type peut avoir plusieurs sites)
    public function sites()
    {
        return $this->hasMany(Site::class);
    }
} 