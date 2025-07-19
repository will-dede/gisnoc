<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des fréquences avec leur relation vers la technologie
    public function up()
    {
        Schema::create('frequences', function (Blueprint $table) {
            $table->id();
            $table->string('nom_freq');
            $table->foreignId('technologie_id')->constrained('technologies');
            // $table->foreignId('technologie_id')->nullable()->constrained('technologies')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('frequences');
    }
}; 