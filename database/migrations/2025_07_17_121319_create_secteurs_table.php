<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des secteurs avec leur relation vers la fréquence
    public function up()
    {
        Schema::create('secteurs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_secteur');
            $table->foreignId('frequence_id')->constrained('frequences');
            // $table->foreignId('frequence_id')->nullable()->constrained('frequences')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('secteurs');
    }
}; 