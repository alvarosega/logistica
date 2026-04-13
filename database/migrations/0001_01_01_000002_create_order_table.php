<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Datos del Cliente
            $table->string('codigo_cliente')->index();
            $table->string('razon_social'); // Nombre o Razón Social del destino
            
            // Filtro de Silo ECO
            $table->integer('territorio')->index();
            
            // Logística y Telemetría
            $table->string('codigo_camion')->index();
            $table->date('fecha_entrega')->index();
            
            $table->string('producto');
            $table->integer('cantidad')->unsigned();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};