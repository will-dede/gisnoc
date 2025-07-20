<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Création de la table des sites avec leurs relations vers RNC, BSC, type et zone
    public function up()
    {
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->string('nom_site')->unique();
            $table->string('cell2G', 30)->nullable()->unique();
            $table->string('cell3G', 30)->nullable()->unique();
            $table->string('cell4G', 30)->nullable()->unique();
            $table->string('nodeName', 30)->nullable()->unique();
            $table->string('ip3G', 19)->nullable()->unique();
            $table->string('ip4G', 19)->nullable()->unique();
            $table->foreignId('rnc_id')->constrained('rncs');
            $table->foreignId('bsc_id')->constrained('bscs');
            $table->foreignId('type_site_id')->constrained('type_sites');
            $table->foreignId('zone_maintenance_id')->constrained('zone_maintenances');
            $table->foreignId('region_id')->constrained('regions');
            $table->timestamps();
        });
    }

    // Suppression de la table des sites
    public function down()
    {
        Schema::dropIfExists('sites');
    }
}; 