<?php

namespace Tests\Feature;

use App\Models\Cliente;
use App\Models\Vehicle;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ApiTest — Pruebas de los endpoints de la API REST
 *
 * Valida todas las respuestas de la API REST del autolavado:
 * - GET /api/vehicles           → lista vehículos
 * - POST /api/vehicles          → crea vehículo
 * - GET /api/vehicles/{id}      → detalle vehículo
 * - PUT /api/vehicles/{id}      → actualiza vehículo
 * - DELETE /api/vehicles/{id}   → elimina vehículo
 * - GET /api/clientes           → lista clientes
 * - POST /api/clientes          → crea cliente
 * - GET /api/clientes/{id}      → detalle cliente
 * - PUT /api/clientes/{id}      → actualiza cliente
 * - DELETE /api/clientes/{id}   → elimina cliente
 * - GET /api/clientes/{id}/vehiculos → vehículos de un cliente
 * - GET /api/vehicles/estado/{estado} → filtra por estado
 *
 * Para ejecutar:
 *   php artisan test --filter ApiTest
 *   php artisan test tests/Feature/ApiTest.php
 */
class ApiTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // API DE VEHÍCULOS
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: GET /api/vehicles retorna la lista de vehículos con estructura JSON correcta.
     *
     * Verifica el código HTTP 200 y que la respuesta incluye
     * los campos 'success', 'data' y 'total'.
     */
    public function test_api_retorna_lista_de_vehiculos(): void
    {
        Vehicle::create(['placa' => 'T001', 'propietario' => 'Uno', 'servicio' => 'Básico']);
        Vehicle::create(['placa' => 'T002', 'propietario' => 'Dos', 'servicio' => 'Completo']);

        $response = $this->getJson('/api/vehicles');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [['id_vehiculo', 'placa', 'propietario', 'servicio', 'estado']],
                     'total',
                 ])
                 ->assertJson(['success' => true, 'total' => 2]);
    }

    /**
     * Prueba: POST /api/vehicles crea un vehículo y retorna 201.
     */
    public function test_api_crea_vehiculo_y_retorna_201(): void
    {
        $response = $this->postJson('/api/vehicles', [
            'placa'       => 'NEW001',
            'propietario' => 'Propietario Nuevo',
            'servicio'    => 'Lavado completo',
            'telefono'    => '3109876543',
            'estado'      => 'En espera',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('data.placa', 'NEW001');

        $this->assertDatabaseHas('vehiculo', ['placa' => 'NEW001']);
    }

    /**
     * Prueba: POST /api/vehicles retorna 422 si faltan campos obligatorios.
     */
    public function test_api_vehiculo_falla_sin_placa(): void
    {
        $response = $this->postJson('/api/vehicles', [
            'propietario' => 'Sin Placa',
            'servicio'    => 'Básico',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['placa']);
    }

    /**
     * Prueba: GET /api/vehicles/{id} retorna el detalle de un vehículo.
     */
    public function test_api_retorna_detalle_de_vehiculo(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'DET001',
            'propietario' => 'Detalle Test',
            'servicio'    => 'Polichado',
        ]);

        $response = $this->getJson("/api/vehicles/{$vehicle->id_vehiculo}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.placa', 'DET001')
                 ->assertJsonPath('data.propietario', 'Detalle Test');
    }

    /**
     * Prueba: GET /api/vehicles/{id} retorna 404 si el vehículo no existe.
     */
    public function test_api_vehiculo_inexistente_retorna_404(): void
    {
        $response = $this->getJson('/api/vehicles/99999');

        $response->assertStatus(404)
                 ->assertJson(['success' => false]);
    }

    /**
     * Prueba: PUT /api/vehicles/{id} actualiza un vehículo existente.
     */
    public function test_api_actualiza_vehiculo(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'UPD001',
            'propietario' => 'Original',
            'servicio'    => 'Básico',
            'estado'      => 'En espera',
        ]);

        $response = $this->putJson("/api/vehicles/{$vehicle->id_vehiculo}", [
            'placa'       => 'UPD001',
            'propietario' => 'Original',
            'servicio'    => 'Completo',
            'estado'      => 'Listo',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('vehiculo', [
            'placa'  => 'UPD001',
            'estado' => 'Listo',
        ]);
    }

    /**
     * Prueba: DELETE /api/vehicles/{id} elimina el vehículo y retorna 200.
     */
    public function test_api_elimina_vehiculo(): void
    {
        $vehicle = Vehicle::create([
            'placa'       => 'DEL001',
            'propietario' => 'A Borrar',
            'servicio'    => 'Básico',
        ]);

        $id = $vehicle->id_vehiculo;
        $response = $this->deleteJson("/api/vehicles/{$id}");

        $response->assertStatus(200)
                 ->assertJson(['success' => true, 'message' => 'Vehículo eliminado exitosamente.']);

        $this->assertDatabaseMissing('vehiculo', ['id_vehiculo' => $id]);
    }

    /**
     * Prueba: GET /api/vehicles/estado/{estado} filtra vehículos por estado.
     */
    public function test_api_filtra_vehiculos_por_estado(): void
    {
        Vehicle::create(['placa' => 'S001', 'propietario' => 'A', 'servicio' => 'B', 'estado' => 'Listo']);
        Vehicle::create(['placa' => 'S002', 'propietario' => 'B', 'servicio' => 'C', 'estado' => 'En espera']);

        $response = $this->getJson('/api/vehicles/estado/Listo');

        $response->assertStatus(200)
                 ->assertJson(['success' => true, 'total' => 1, 'estado' => 'Listo']);
    }

    // ─────────────────────────────────────────────────────────
    // API DE CLIENTES
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: GET /api/clientes retorna la lista de clientes con estructura JSON correcta.
     */
    public function test_api_retorna_lista_de_clientes(): void
    {
        Cliente::create(['nombre' => 'Cliente A', 'correo' => 'a@mail.com']);
        Cliente::create(['nombre' => 'Cliente B', 'correo' => 'b@mail.com']);

        $response = $this->getJson('/api/clientes');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'success',
                     'data' => [['id_cliente', 'nombre']],
                     'total',
                 ])
                 ->assertJson(['success' => true, 'total' => 2]);
    }

    /**
     * Prueba: POST /api/clientes crea un cliente y retorna 201.
     */
    public function test_api_crea_cliente_y_retorna_201(): void
    {
        $response = $this->postJson('/api/clientes', [
            'nombre'   => 'Nuevo Cliente API',
            'telefono' => '3150000001',
            'correo'   => 'nuevo@api.com',
        ]);

        $response->assertStatus(201)
                 ->assertJson(['success' => true])
                 ->assertJsonPath('data.nombre', 'Nuevo Cliente API');

        $this->assertDatabaseHas('cliente', ['correo' => 'nuevo@api.com']);
    }

    /**
     * Prueba: POST /api/clientes retorna 422 si falta el nombre.
     */
    public function test_api_cliente_falla_sin_nombre(): void
    {
        $response = $this->postJson('/api/clientes', [
            'correo' => 'sinombre@mail.com',
        ]);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nombre']);
    }

    /**
     * Prueba: GET /api/clientes/{id} retorna el detalle de un cliente con sus vehículos.
     */
    public function test_api_retorna_detalle_de_cliente(): void
    {
        $cliente = Cliente::create([
            'nombre' => 'Cliente Detalle',
            'correo' => 'detalle@mail.com',
        ]);

        $response = $this->getJson("/api/clientes/{$cliente->id_cliente}");

        $response->assertStatus(200)
                 ->assertJsonPath('data.nombre', 'Cliente Detalle')
                 ->assertJsonStructure(['success', 'data' => ['id_cliente', 'nombre', 'vehiculos']]);
    }

    /**
     * Prueba: GET /api/clientes/{id} retorna 404 si el cliente no existe.
     */
    public function test_api_cliente_inexistente_retorna_404(): void
    {
        $response = $this->getJson('/api/clientes/99999');

        $response->assertStatus(404)
                 ->assertJson(['success' => false]);
    }

    /**
     * Prueba: PUT /api/clientes/{id} actualiza un cliente existente.
     */
    public function test_api_actualiza_cliente(): void
    {
        $cliente = Cliente::create([
            'nombre' => 'Original',
            'correo' => 'original@mail.com',
        ]);

        $response = $this->putJson("/api/clientes/{$cliente->id_cliente}", [
            'nombre'   => 'Actualizado',
            'telefono' => '3001111111',
            'correo'   => 'original@mail.com',
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('cliente', [
            'id_cliente' => $cliente->id_cliente,
            'nombre'     => 'Actualizado',
        ]);
    }

    /**
     * Prueba: DELETE /api/clientes/{id} elimina el cliente y retorna 200.
     */
    public function test_api_elimina_cliente(): void
    {
        $cliente = Cliente::create([
            'nombre' => 'A Eliminar',
            'correo' => 'eliminar@mail.com',
        ]);

        $id = $cliente->id_cliente;
        $response = $this->deleteJson("/api/clientes/{$id}");

        $response->assertStatus(200)
                 ->assertJson(['success' => true, 'message' => 'Cliente eliminado exitosamente.']);

        $this->assertDatabaseMissing('cliente', ['id_cliente' => $id]);
    }

    /**
     * Prueba: GET /api/clientes/{id}/vehiculos retorna los vehículos de un cliente.
     */
    public function test_api_retorna_vehiculos_de_un_cliente(): void
    {
        $cliente = Cliente::create(['nombre' => 'Multi Vehículos']);

        Vehicle::create([
            'placa'      => 'M001', 'propietario' => $cliente->nombre,
            'servicio'   => 'Básico', 'id_cliente' => $cliente->id_cliente,
        ]);
        Vehicle::create([
            'placa'      => 'M002', 'propietario' => $cliente->nombre,
            'servicio'   => 'Completo', 'id_cliente' => $cliente->id_cliente,
        ]);

        $response = $this->getJson("/api/clientes/{$cliente->id_cliente}/vehiculos");

        $response->assertStatus(200)
                 ->assertJson(['success' => true, 'total' => 2])
                 ->assertJsonPath('cliente', $cliente->nombre);
    }

    /**
     * Prueba: GET /api/ (raíz de la API) retorna el estado del sistema.
     */
    public function test_api_raiz_retorna_estado_del_sistema(): void
    {
        $response = $this->getJson('/api/');

        $response->assertStatus(200)
                 ->assertJson(['success' => true])
                 ->assertJsonStructure(['success', 'app', 'version', 'message', 'endpoints']);
    }
}
