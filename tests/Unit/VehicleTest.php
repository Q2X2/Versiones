<?php

namespace Tests\Unit;

use App\Models\Vehicle;
use App\Models\Cliente;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * VehicleTest — Pruebas unitarias del modelo Vehicle
 *
 * Valida el comportamiento del modelo Vehicle:
 * registro, consulta, actualización, eliminación y relaciones.
 *
 * Para ejecutar:
 *   php artisan test --filter VehicleTest
 *   php artisan test tests/Unit/VehicleTest.php
 */
class VehicleTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // 1. REGISTRO DE VEHÍCULOS
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede registrar un vehículo en la base de datos.
     *
     * Verifica que Vehicle::create persiste placa, propietario
     * y servicio, y que el estado por defecto es "En espera".
     */
    public function test_se_puede_registrar_un_vehiculo(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'ABC123',
            'propietario' => 'Juan García',
            'servicio'    => 'Lavado completo',
            'modelo'      => 'Toyota Corolla 2020',
            'telefono'    => '3100000001',
        ]);

        $this->assertDatabaseHas('vehiculo', [
            'placa'    => 'ABC123',
            'servicio' => 'Lavado completo',
        ]);

        $this->assertEquals('En espera', $vehicle->estado);
        $this->assertNotNull($vehicle->id_vehiculo);
    }

    /**
     * Prueba: se puede registrar un vehículo con estado personalizado.
     */
    public function test_se_puede_registrar_vehiculo_con_estado_en_proceso(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'XYZ456',
            'propietario' => 'Pedro Ruiz',
            'servicio'    => 'Lavado básico',
            'estado'      => 'En proceso',
        ]);

        $this->assertEquals('En proceso', $vehicle->estado);
        $this->assertDatabaseHas('vehiculo', [
            'placa'  => 'XYZ456',
            'estado' => 'En proceso',
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // 2. CONSULTA DE VEHÍCULOS
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede consultar la lista de vehículos registrados.
     */
    public function test_se_puede_consultar_lista_de_vehiculos(): void
    {
        Vehicle::create(['placa' => 'AAA111', 'propietario' => 'Uno', 'servicio' => 'Lavado básico']);
        Vehicle::create(['placa' => 'BBB222', 'propietario' => 'Dos', 'servicio' => 'Lavado completo']);
        Vehicle::create(['placa' => 'CCC333', 'propietario' => 'Tres', 'servicio' => 'Polichado']);

        $vehicles = Vehicle::all();

        $this->assertCount(3, $vehicles);
    }

    /**
     * Prueba: se puede consultar un vehículo específico por su placa.
     */
    public function test_se_puede_consultar_vehiculo_por_placa(): void
    {
        Vehicle::create([
            'placa'       => 'PLQ999',
            'propietario' => 'Ramón Díaz',
            'servicio'    => 'Lavado exterior',
        ]);

        $vehicleEncontrado = Vehicle::where('placa', 'PLQ999')->first();

        $this->assertNotNull($vehicleEncontrado);
        $this->assertEquals('Ramón Díaz', $vehicleEncontrado->propietario);
    }

    /**
     * Prueba: se pueden filtrar vehículos por estado.
     */
    public function test_se_puede_filtrar_vehiculos_por_estado(): void
    {
        Vehicle::create(['placa' => 'E001', 'propietario' => 'A', 'servicio' => 'S1', 'estado' => 'En espera']);
        Vehicle::create(['placa' => 'E002', 'propietario' => 'B', 'servicio' => 'S2', 'estado' => 'En espera']);
        Vehicle::create(['placa' => 'E003', 'propietario' => 'C', 'servicio' => 'S3', 'estado' => 'Listo']);

        $enEspera = Vehicle::where('estado', 'En espera')->get();
        $listos   = Vehicle::where('estado', 'Listo')->get();

        $this->assertCount(2, $enEspera);
        $this->assertCount(1, $listos);
    }

    // ─────────────────────────────────────────────────────────
    // 3. ACTUALIZACIÓN DE INFORMACIÓN
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede actualizar el estado de un vehículo.
     *
     * Simula el flujo del autolavado: espera → en proceso → listo.
     */
    public function test_se_puede_actualizar_estado_de_vehiculo(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'UPD001',
            'propietario' => 'Actualizar Test',
            'servicio'    => 'Lavado completo',
            'estado'      => 'En espera',
        ]);

        $vehicle->update(['estado' => 'Listo']);

        $this->assertDatabaseHas('vehiculo', [
            'placa'  => 'UPD001',
            'estado' => 'Listo',
        ]);

        $this->assertDatabaseMissing('vehiculo', [
            'placa'  => 'UPD001',
            'estado' => 'En espera',
        ]);
    }

    /**
     * Prueba: se puede actualizar la información general del vehículo.
     */
    public function test_se_puede_actualizar_informacion_de_vehiculo(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'MOD001',
            'propietario' => 'Sin Modelo',
            'servicio'    => 'Lavado básico',
        ]);

        $vehicle->update([
            'modelo'   => 'Honda Civic 2022',
            'telefono' => '3201234567',
            'servicio' => 'Lavado completo',
        ]);

        $this->assertDatabaseHas('vehiculo', [
            'placa'   => 'MOD001',
            'modelo'  => 'Honda Civic 2022',
            'servicio' => 'Lavado completo',
        ]);
    }

    // ─────────────────────────────────────────────────────────
    // 4. ELIMINACIÓN DE REGISTROS
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede eliminar un vehículo de la base de datos.
     */
    public function test_se_puede_eliminar_un_vehiculo(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'DEL001',
            'propietario' => 'A Eliminar',
            'servicio'    => 'Lavado básico',
        ]);

        $id = $vehicle->id_vehiculo;
        $vehicle->delete();

        $this->assertDatabaseMissing('vehiculo', ['id_vehiculo' => $id]);
        $this->assertNull(Vehicle::find($id));
    }

    // ─────────────────────────────────────────────────────────
    // 5. RELACIONES
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: un vehículo pertenece a un cliente (relación belongsTo).
     */
    public function test_vehiculo_pertenece_a_un_cliente(): void
    {
        $cliente = Cliente::create(['nombre' => 'Propietario Relación']);

        $vehicle = Vehicle::create([
            'placa'       => 'REL001',
            'propietario' => $cliente->nombre,
            'servicio'    => 'Lavado completo',
            'id_cliente'  => $cliente->id_cliente,
        ]);

        $this->assertNotNull($vehicle->cliente);
        $this->assertEquals($cliente->nombre, $vehicle->cliente->nombre);
    }

    /**
     * Prueba: un vehículo puede existir sin cliente asociado.
     */
    public function test_vehiculo_puede_existir_sin_cliente(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'SIN001',
            'propietario' => 'Sin Cliente',
            'servicio'    => 'Lavado básico',
        ]);

        $this->assertNull($vehicle->id_cliente);
        $this->assertNull($vehicle->cliente);
    }
}
