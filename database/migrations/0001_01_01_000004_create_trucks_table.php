<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('codigo_camion')->unique()->index();
            $table->string('sru')->nullable(); // Identificador de unidad/servicio
            $table->string('region')->index(); // Para filtrado geográfico
            $table->string('cel');            // Contacto del conductor
            $table->string('nombre');         // Nombre del conductor o camión
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};