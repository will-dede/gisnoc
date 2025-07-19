<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table pivot pour la relation plusieurs-à-plusieurs entre sites et technologies
    public function up()
    {
        Schema::create('site_technologie', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites');
            // $table->foreignId('site_id')->nullable()->constrained('sites')->nullOnDelete();
            $table->foreignId('technologie_id')->constrained('technologies');
            // $table->foreignId('technologie_id')->nullable()->constrained('technologies')->nullOnDelete();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('site_technologie');
    }
};