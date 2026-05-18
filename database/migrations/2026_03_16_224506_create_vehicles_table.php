<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Crea las tablas cliente y vehiculo.
 * 
 * Se crea primero cliente porque vehiculo tiene FK a cliente.
 */
return new class extends Migration
{
    /**
     * Ejecutar las migraciones.
     * Crea la tabla cliente y la tabla vehiculo.
     */
    public function up(): void
    {
        // Tabla de clientes del autolavado
        Schema::create('cliente', function (Blueprint $table) {
            $table->increments('id_cliente');
            $table->string('nombre', 100);
            $table->string('telefono', 20)->nullable();
            $table->string('correo', 100)->nullable()->unique();
        });

        // Tabla de vehículos registrados en el autolavado
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->increments('id_vehiculo');
            $table->string('placa', 20)->unique();
            $table->string('propietario', 100);
            $table->string('telefono', 20)->nullable();
            $table->string('modelo', 80)->nullable();
            $table->string('servicio', 100);
            $table->string('estado', 50)->default('En espera');
            $table->time('hora')->nullable();
            // Llave foránea opcional hacia cliente
            $table->unsignedInteger('id_cliente')->nullable();
            $table->foreign('id_cliente')->references('id_cliente')->on('cliente')->onDelete('set null');
        });
    }

    /**
     * Revertir las migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
        Schema::dropIfExists('cliente');
    }
};
