<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des incidents avec leurs relations vers technicien, type d'alarme et utilisateur
    public function up()
    {
        Schema::create('incidents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites');
            $table->dateTime('date_debut_incident');
            $table->dateTime('date_fin_incident')->nullable();
            $table->dateTime('date_contact_technicien')->nullable();
            $table->dateTime('date_arrivee_sur_site')->nullable();
            $table->string('intervenant', 50)->nullable();
            $table->text('causes_incident')->nullable();
            $table->text('actions_effectuees')->nullable();
            $table->text('observation')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('technicien_id')->constrained('techniciens')->nullable();
            $table->foreignId('type_alarme_id')->constrained('type_alarmes')->nullable();
            // $table->foreignId('user_id')->constrained('users')->nullable(); //Avec ou sans S ?
            $table->timestamps();
        });
    }

    // Suppression de la table des incidents
    public function down()
    {
        Schema::dropIfExists('incidents');
    }
}; 