<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des technologies
    public function up()
    {
        Schema::create('technologies', function (Blueprint $table) {
            $table->id();
            $table->string('nom_technologie', 15)->unique();
            $table->timestamps();
        });
    }

    // Suppression de la table des technologies
    public function down()
    {
        Schema::dropIfExists('technologies');
    }
}; 