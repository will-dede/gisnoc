<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des mecaniciens avec leur zone de maintenance
    public function up()
    {
        Schema::create('mecaniciens', function (Blueprint $table) {
            $table->id();
            $table->string('nom_mecano', 70);
            $table->string('prenom_mecano', 70);
            $table->string('tel_mecano', 30);
            $table->boolean('est_proprietaire')->default(false);
            $table->foreignId('zone_maintenance_id')->constrained('zone_maintenances');
            // $table->foreignId('zone_maintenance_id')->nullable()->constrained('zone_maintenances')->nullOnDelete();
            $table->timestamps();
        });
    }

    // Suppression de la table des mecaniciens
    public function down()
    {
        Schema::dropIfExists('mecaniciens');
    }
}; 