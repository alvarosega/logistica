<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            
            // Ahora es un campo de búsqueda pública, no una llave foránea
            $table->string('codigo_cliente')->index();
            
            // Campo para el filtrado del Silo ECO
            $table->integer('territorio')->index();
            
            // Índices para optimización de logística
            $table->string('codigo_camion')->index();
            $table->date('fecha_entrega')->index();
            
            $table->string('producto');
            $table->integer('cantidad')->unsigned();
            $table->timestamps();
            
            // Nota: Para una llave foránea formal a 'users.territorio', 
            // dicho campo en 'users' DEBE ser único, lo cual no suele ocurrir 
            // si varios usuarios ECO comparten territorio. Por ahora se mantiene indexado.
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};