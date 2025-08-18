<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des NodeTypes
    public function up()
    {
        Schema::create('type_sites', function (Blueprint $table) {
            $table->id();
            $table->string('nom_type_site', 25)->unique();
            $table->timestamps();
        });
    }

    // Suppression de la table des NodeTypes
    public function down()
    {
        Schema::dropIfExists('type_sites');
    }
};