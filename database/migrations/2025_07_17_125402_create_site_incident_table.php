<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('site_incident', function (Blueprint $table) {
            $table->id();
            $table->foreignId('site_id')->constrained('sites');
            // $table->foreignId('site_id')->nullable()->constrained('sites')->nullOnDelete(); La suppression d'un site n'entraine pas la suppression de l'incident
            $table->foreignId('incident_id')->constrained('incidents');
            // $table->foreignId('incident_id')->nullable()->constrained('incidents')->nullOnDelete(); La suppression d'un incident n'entraine pas la suppression du site

            $table->dateTime('date_debut_incident')->nullable();
            $table->dateTime('date_fin_incident')->nullable();
            $table->dateTime('date_arrivee_sur_site')->nullable();
            $table->string('intervenant', 50)->nullable();
            $table->text('causes_incident')->nullable();
            $table->text('actions_effectuees')->nullable();
            $table->text('observation')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('technicien_id')->nullable()->constrained('techniciens');
            $table->foreignId('type_alarme_id')->nullable()->constrained('type_alarmes');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('site_incident');
    }
}; 