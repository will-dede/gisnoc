<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des BSC
    public function up()
    {
        Schema::create('bscs', function (Blueprint $table) {
            $table->id();
            $table->string('nom_bsc', 50)->unique();
            $table->timestamps();
        });
    }

    // Suppression de la table des BSC
    public function down()
    {
        Schema::dropIfExists('bscs');
    }
}; 