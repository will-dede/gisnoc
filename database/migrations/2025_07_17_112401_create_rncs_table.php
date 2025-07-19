<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des RNC
    public function up()
    {
        Schema::create('rncs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_rnc', 50)->unique();
            $table->timestamps();
        });
    }

    // Suppression de la table des RNC
    public function down()
    {
        Schema::dropIfExists('rncs');
    }
}; 