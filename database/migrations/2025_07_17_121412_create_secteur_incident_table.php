<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('secteur_incident', function (Blueprint $table) {
            $table->id();
            $table->foreignId('secteur_id')->constrained('secteurs');
            // $table->foreignId('secteur_id')->nullable()->constrained('secteurs')->nullOnDelete();
            $table->foreignId('incident_id')->constrained('incidents');
            // $table->foreignId('incident_id')->nullable()->constrained('incidents')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('secteur_incident');
    }
}; 