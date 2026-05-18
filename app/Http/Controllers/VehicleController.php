<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    // GET /vehicles — lista todos los vehículos
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('vehicles.index', compact('vehicles'));
    }

    // GET /vehicles/create — formulario de registro
    public function create()
    {
        return view('vehicles.create');
    }

    // POST /vehicles — guarda el nuevo vehículo
    public function store(Request $request)
    {
        $request->validate([
            'placa'       => 'required|string|max:20|unique:vehiculo,placa',
            'propietario' => 'required|string|max:100',
            'servicio'    => 'required|string|max:100',
        ]);

        Vehicle::create([
            'placa'       => strtoupper($request->placa),
            'propietario' => $request->propietario,
            'telefono'    => $request->telefono,
            'modelo'      => $request->modelo,
            'servicio'    => $request->servicio,
            'estado'      => $request->estado ?? 'En espera',
            'hora'        => $request->hora,
        ]);

        return redirect()->route('vehicles.index');
    }

    // GET /vehicles/{id} — detalle del vehículo
    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicles.show', compact('vehicle'));
    }

    // GET /vehicles/{id}/edit — formulario de edición
    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicles.edit', compact('vehicle'));
    }

    // PUT /vehicles/{id} — actualiza el vehículo
    public function update(Request $request, $id)
    {
        $request->validate([
            'placa'       => 'required|string|max:20|unique:vehiculo,placa,' . $id . ',id_vehiculo',
            'propietario' => 'required|string|max:100',
            'servicio'    => 'required|string|max:100',
        ]);

        $vehicle = Vehicle::findOrFail($id);

        $vehicle->update([
            'placa'       => strtoupper($request->placa),
            'propietario' => $request->propietario,
            'telefono'    => $request->telefono,
            'modelo'      => $request->modelo,
            'servicio'    => $request->servicio,
            'estado'      => $request->estado,
            'hora'        => $request->hora,
        ]);

        return redirect()->route('vehicles.index');
    }

    // DELETE /vehicles/{id} — elimina el vehículo
    public function destroy($id)
    {
        Vehicle::destroy($id);
        return redirect()->route('vehicles.index');
    }
}
