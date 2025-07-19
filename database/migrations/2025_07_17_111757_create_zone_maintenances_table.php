<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des zones de maintenance
    public function up()
    {
        Schema::create('zone_maintenances', function (Blueprint $table) {
            $table->id();
            $table->string('nom_zone', 50)->unique();
            $table->timestamps();
        });
    }

    // Suppression de la table des zones de maintenance
    public function down()
    {
        Schema::dropIfExists('zone_maintenances');
    }
}; 