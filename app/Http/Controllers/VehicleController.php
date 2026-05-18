<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Cliente;
use Inertia\Inertia;

/**
 * VehicleController
 *
 * Controlador CRUD para vehículos del autolavado.
 * Retorna respuestas Inertia (React) en lugar de Blade.
 * Los errores de $request->validate se inyectan automáticamente en React.
 */
class VehicleController extends Controller
{
    /**
     * GET /vehicles
     * Retorna la página React Vehicles/Index con todos los vehículos.
     */
    public function index()
    {
        // Obtener vehículos con cliente relacionado
        $vehicles = Vehicle::with('cliente')->get();

        return Inertia::render('Vehicles/Index', [
            'vehicles' => $vehicles,
        ]);
    }

    /**
     * GET /vehicles/create
     * Retorna la página React Vehicles/Create con lista de clientes.
     */
    public function create()
    {
        $clientes = Cliente::all();

        return Inertia::render('Vehicles/Create', [
            'clientes' => $clientes,
        ]);
    }

    /**
     * POST /vehicles
     * Valida y guarda un nuevo vehículo. Los errores se inyectan en React.
     */
    public function store(Request $request)
    {
        // Validación: errores se pasan automáticamente al componente React via Inertia
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

        Vehicle::create([
            'placa'       => strtoupper($request->placa),
            'propietario' => $request->propietario,
            'telefono'    => $request->telefono,
            'modelo'      => $request->modelo,
            'servicio'    => $request->servicio,
            'estado'      => $request->estado ?? 'En espera',
            'hora'        => $request->hora ?: null,
            'id_cliente'  => $request->id_cliente ?: null,
        ]);

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehículo registrado exitosamente.');
    }

    /**
     * GET /vehicles/{id}
     * Retorna la página React Vehicles/Show con el detalle del vehículo.
     */
    public function show($id)
    {
        $vehicle = Vehicle::with('cliente')->findOrFail($id);

        return Inertia::render('Vehicles/Show', [
            'vehicle' => $vehicle,
        ]);
    }

    /**
     * GET /vehicles/{id}/edit
     * Retorna la página React Vehicles/Edit con datos del vehículo.
     */
    public function edit($id)
    {
        $vehicle  = Vehicle::findOrFail($id);
        $clientes = Cliente::all();

        return Inertia::render('Vehicles/Edit', [
            'vehicle'  => $vehicle,
            'clientes' => $clientes,
        ]);
    }

    /**
     * PUT /vehicles/{id}
     * Valida y actualiza los datos del vehículo.
     */
    public function update(Request $request, $id)
    {
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
        $vehicle->update([
            'placa'       => strtoupper($request->placa),
            'propietario' => $request->propietario,
            'telefono'    => $request->telefono,
            'modelo'      => $request->modelo,
            'servicio'    => $request->servicio,
            'estado'      => $request->estado,
            'hora'        => $request->hora ?: null,
            'id_cliente'  => $request->id_cliente ?: null,
        ]);

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

        return redirect()->route('vehicles.index')
            ->with('success', 'Vehículo eliminado exitosamente.');
    }
}
