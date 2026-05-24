<?php

namespace Tests\Unit;

use App\Models\Cliente;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * ClienteTest — Pruebas unitarias del modelo Cliente
 *
 * Valida el comportamiento del modelo Cliente:
 * registro, consulta, actualización, eliminación y relaciones.
 *
 * Usa SQLite en memoria (configurado en phpunit.xml) para
 * no afectar la base de datos de desarrollo.
 *
 * Para ejecutar:
 *   php artisan test --filter ClienteTest
 *   php artisan test tests/Unit/ClienteTest.php
 */
class ClienteTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // 1. REGISTRO DE CLIENTES
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede registrar un cliente en la base de datos.
     *
     * Verifica que el modelo Cliente::create persiste correctamente
     * el nombre, teléfono y correo en la tabla cliente.
     */
    public function test_se_puede_registrar_un_cliente(): void
    {
        $cliente = Cliente::create([
            'nombre'   => 'Carlos Pérez',
            'telefono' => '3001234567',
            'correo'   => 'carlos@correo.com',
        ]);

        $this->assertDatabaseHas('cliente', [
            'nombre' => 'Carlos Pérez',
            'correo' => 'carlos@correo.com',
        ]);

        $this->assertNotNull($cliente->id_cliente);
    }

    /**
     * Prueba: se puede registrar un cliente sin teléfono ni correo (campos opcionales).
     */
    public function test_se_puede_registrar_cliente_solo_con_nombre(): void
    {
        $cliente = Cliente::create(['nombre' => 'Ana Sin Contacto']);

        $this->assertDatabaseHas('cliente', ['nombre' => 'Ana Sin Contacto']);
        $this->assertNull($cliente->telefono);
        $this->assertNull($cliente->correo);
    }

    // ─────────────────────────────────────────────────────────
    // 2. CONSULTA DE CLIENTES
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede consultar la lista de clientes registrados.
     *
     * Crea 3 clientes y verifica que Cliente::all() los retorna.
     */
    public function test_se_puede_consultar_lista_de_clientes(): void
    {
        Cliente::create(['nombre' => 'Cliente Uno', 'correo' => 'uno@mail.com']);
        Cliente::create(['nombre' => 'Cliente Dos', 'correo' => 'dos@mail.com']);
        Cliente::create(['nombre' => 'Cliente Tres']);

        $clientes = Cliente::all();

        $this->assertCount(3, $clientes);
    }

    /**
     * Prueba: se puede consultar un cliente específico por su ID.
     */
    public function test_se_puede_consultar_cliente_por_id(): void
    {
        $clienteCreado = Cliente::create([
            'nombre' => 'María López',
            'correo' => 'maria@mail.com',
        ]);

        $clienteEncontrado = Cliente::find($clienteCreado->id_cliente);

        $this->assertNotNull($clienteEncontrado);
        $this->assertEquals('María López', $clienteEncontrado->nombre);
    }

    // ─────────────────────────────────────────────────────────
    // 3. ACTUALIZACIÓN DE INFORMACIÓN
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede actualizar la información de un cliente.
     *
     * Verifica que los datos nuevos persisten en la base de datos
     * y los datos anteriores ya no existen.
     */
    public function test_se_puede_actualizar_informacion_de_cliente(): void
    {
        $cliente = Cliente::create([
            'nombre'   => 'Luis Antes',
            'telefono' => '3000000000',
            'correo'   => 'luis@mail.com',
        ]);

        $cliente->update([
            'nombre'   => 'Luis Actualizado',
            'telefono' => '3119999999',
        ]);

        $this->assertDatabaseHas('cliente', [
            'id_cliente' => $cliente->id_cliente,
            'nombre'     => 'Luis Actualizado',
            'telefono'   => '3119999999',
        ]);

        $this->assertDatabaseMissing('cliente', ['nombre' => 'Luis Antes']);
    }

    // ─────────────────────────────────────────────────────────
    // 4. ELIMINACIÓN DE REGISTROS
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede eliminar un cliente de la base de datos.
     *
     * Verifica que después de delete() el registro ya no existe.
     */
    public function test_se_puede_eliminar_un_cliente(): void
    {
        $cliente = Cliente::create([
            'nombre' => 'Cliente A Eliminar',
            'correo' => 'eliminar@mail.com',
        ]);

        $id = $cliente->id_cliente;
        $cliente->delete();

        $this->assertDatabaseMissing('cliente', ['id_cliente' => $id]);
        $this->assertNull(Cliente::find($id));
    }

    // ─────────────────────────────────────────────────────────
    // 5. RELACIONES
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: un cliente puede tener múltiples vehículos asociados.
     *
     * Verifica la relación hasMany Cliente → Vehicle.
     */
    public function test_cliente_tiene_relacion_con_vehiculos(): void
    {
        $cliente = Cliente::create(['nombre' => 'Cliente Con Vehículos']);

        Vehicle::create([
            'placa'       => 'ABC123',
            'propietario' => $cliente->nombre,
            'servicio'    => 'Lavado básico',
            'id_cliente'  => $cliente->id_cliente,
        ]);

        Vehicle::create([
            'placa'       => 'XYZ789',
            'propietario' => $cliente->nombre,
            'servicio'    => 'Lavado completo',
            'id_cliente'  => $cliente->id_cliente,
        ]);

        $this->assertCount(2, $cliente->vehiculos);
    }
}
