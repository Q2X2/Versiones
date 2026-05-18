<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehiculo', function (Blueprint $table) {
            $table->increments('id_vehiculo');
            $table->string('placa', 20)->unique();
            $table->string('propietario', 100);
            $table->string('telefono', 20)->nullable();
            $table->string('modelo', 80)->nullable();
            $table->string('servicio', 100);
            $table->string('estado', 50)->default('En espera');
            $table->time('hora')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehiculo');
    }
};
