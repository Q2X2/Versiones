<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Cliente;

/**
 * VehicleController
 *
 * Controlador CRUD para la gestión de vehículos del autolavado.
 * Incluye mensajes flash de éxito y validación con mensajes en español.
 */
class VehicleController extends Controller
{
    /**
     * GET /vehicles
     * Muestra la lista de todos los vehículos registrados (turnos).
     */
    public function index()
    {
        // Obtener todos los vehículos con su cliente relacionado
        $vehicles = Vehicle::with('cliente')->get();

        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * GET /vehicles/create
     * Muestra el formulario para registrar un nuevo vehículo.
     */
    public function create()
    {
        // Pasar lista de clientes al formulario para el select
        $clientes = Cliente::all();

        return view('vehicles.create', compact('clientes'));
    }

    /**
     * POST /vehicles
     * Valida y guarda un nuevo vehículo en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación con mensajes de error en español
        $request->validate([
            'placa'       => 'required|string|max:20|unique:vehiculo,placa',
            'propietario' => 'required|string|max:100',
            'servicio'    => 'required|string|max:100',
            'id_cliente'  => 'nullable|exists:cliente,id_cliente',
        ], [
            'placa.required'       => 'La placa es obligatoria.',
            'placa.unique'         => 'Esta placa ya está registrada.',
            'propietario.required' => 'El nombre del propietario es obligatorio.',
            'servicio.required'    => 'El servicio es obligatorio.',
            'id_cliente.exists'    => 'El cliente seleccionado no existe.',
        ]);

        // Crear el vehículo con los datos validados
        Vehicle::create([
            'placa'       => strtoupper($request->placa),
            'propietario' => $request->propietario,
            'telefono'    => $request->telefono,
            'modelo'      => $request->modelo,
            'servicio'    => $request->servicio,
            'estado'      => $request->estado ?? 'En espera',
            'hora'        => $request->hora,
            'id_cliente'  => $request->id_cliente,
        ]);

        // Mensaje flash de éxito al crear
        return redirect()->route('vehicles.index')
            ->with('success', 'Vehículo registrado exitosamente.');
    }

    /**
     * GET /vehicles/{id}
     * Muestra el detalle y estado de un vehículo específico.
     */
    public function show($id)
    {
        // Buscar vehículo o retornar 404
        $vehicle = Vehicle::with('cliente')->findOrFail($id);

        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * GET /vehicles/{id}/edit
     * Muestra el formulario para editar un vehículo existente.
     */
    public function edit($id)
    {
        $vehicle  = Vehicle::findOrFail($id);
        $clientes = Cliente::all();

        return view('vehicles.edit', compact('vehicle', 'clientes'));
    }

    /**
     * PUT /vehicles/{id}
     * Valida y actualiza los datos de un vehículo existente.
     */
    public function update(Request $request, $id)
    {
        // Validación ignorando la placa del vehículo actual (unique)
        $request->validate([
            'placa'       => 'required|string|max:20|unique:vehiculo,placa,' . $id . ',id_vehiculo',
            'propietario' => 'required|string|max:100',
            'servicio'    => 'required|string|max:100',
            'id_cliente'  => 'nullable|exists:cliente,id_cliente',
        ], [
            'placa.required'       => 'La placa es obligatoria.',
            'placa.unique'         => 'Esta placa ya está registrada.',
            'propietario.required' => 'El nombre del propietario es obligatorio.',
            'servicio.required'    => 'El servicio es obligatorio.',
            'id_cliente.exists'    => 'El cliente seleccionado no existe.',
        ]);

        $vehicle = Vehicle::findOrFail($id);

        // Actualizar campos del vehículo
        $vehicle->update([
            'placa'       => strtoupper($request->placa),
            'propietario' => $request->propietario,
            'telefono'    => $request->telefono,
            'modelo'      => $request->modelo,
            'servicio'    => $request->servicio,
            'estado'      => $request->estado,
            'hora'        => $request->hora,
            'id_cliente'  => $request->id_cliente,
        ]);

        // Mensaje flash de éxito al actualizar
        return redirect()->route('vehicles.index')
            ->with('success', 'Vehículo actualizado exitosamente.');
    }

    /**
     * DELETE /vehicles/{id}
     * Elimina un vehículo de la base de datos.
     */
    public function destroy($id)
    {
        Vehicle::destroy($id);

        // Mensaje flash de éxito al eliminar
        return redirect()->route('vehicles.index')
            ->with('success', 'Vehículo eliminado exitosamente.');
    }
}
