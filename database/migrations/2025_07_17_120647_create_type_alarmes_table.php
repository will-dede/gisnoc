<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des types d'alarme
    public function up()
    {
        Schema::create('type_alarmes', function (Blueprint $table) {
            $table->id();
            $table->string('nom_type_alarme', 5)->unique();
            $table->text('descr_type_alarme')->nullable();
            $table->timestamps();
        });
    }

    // Suppression de la table des types d'alarme
    public function down()
    {
        Schema::dropIfExists('type_alarmes');
    }
};