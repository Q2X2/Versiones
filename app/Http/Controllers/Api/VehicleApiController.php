<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use App\Models\Cliente;

/**
 * VehicleApiController
 *
 * Controlador API REST para vehículos del autolavado.
 * Expone endpoints JSON consumibles por cualquier aplicación externa
 * (móvil, frontend React independiente, Postman, etc.)
 *
 * Base URL: /api/vehicles
 * Estándar: REST con respuestas JSON y códigos HTTP correctos
 */
class VehicleApiController extends Controller
{
    /**
     * GET /api/vehicles
     * Retorna lista completa de vehículos en formato JSON.
     * Incluye el cliente relacionado si existe.
     */
    public function index()
    {
        // Obtener todos los vehículos con su cliente relacionado
        $vehicles = Vehicle::with('cliente')->get();

        return response()->json([
            'success' => true,
            'data'    => $vehicles,
            'total'   => $vehicles->count(),
        ], 200);
    }

    /**
     * POST /api/vehicles
     * Crea un nuevo vehículo. Recibe y retorna JSON.
     * Retorna 201 Created si es exitoso, 422 si hay errores de validación.
     */
    public function store(Request $request)
    {
        // Validación estándar REST — errores retornan 422 con JSON
        $validated = $request->validate([
            'placa'       => 'required|string|max:20|unique:vehiculo,placa',
            'propietario' => 'required|string|max:100',
            'servicio'    => 'required|string|max:100',
            'telefono'    => 'nullable|string|max:20',
            'modelo'      => 'nullable|string|max:80',
            'estado'      => 'nullable|string|in:En espera,En proceso,Listo',
            'hora'        => 'nullable|date_format:H:i',
            'id_cliente'  => 'nullable|exists:cliente,id_cliente',
        ]);

        // Crear el vehículo con los datos validados
        $vehicle = Vehicle::create([
            'placa'       => strtoupper($validated['placa']),
            'propietario' => $validated['propietario'],
            'servicio'    => $validated['servicio'],
            'telefono'    => $validated['telefono'] ?? null,
            'modelo'      => $validated['modelo'] ?? null,
            'estado'      => $validated['estado'] ?? 'En espera',
            'hora'        => $validated['hora'] ?? null,
            'id_cliente'  => $validated['id_cliente'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehículo registrado exitosamente.',
            'data'    => $vehicle,
        ], 201);
    }

    /**
     * GET /api/vehicles/{id}
     * Retorna el detalle de un vehículo específico.
     * Retorna 404 si no existe.
     */
    public function show($id)
    {
        // Buscar vehículo o retornar 404 JSON
        $vehicle = Vehicle::with('cliente')->find($id);

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehículo no encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $vehicle,
        ], 200);
    }

    /**
     * PUT /api/vehicles/{id}
     * Actualiza un vehículo existente.
     * Retorna 404 si no existe, 422 si hay errores de validación.
     */
    public function update(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehículo no encontrado.',
            ], 404);
        }

        $validated = $request->validate([
            'placa'       => 'required|string|max:20|unique:vehiculo,placa,' . $id . ',id_vehiculo',
            'propietario' => 'required|string|max:100',
            'servicio'    => 'required|string|max:100',
            'telefono'    => 'nullable|string|max:20',
            'modelo'      => 'nullable|string|max:80',
            'estado'      => 'nullable|string|in:En espera,En proceso,Listo',
            'hora'        => 'nullable|date_format:H:i',
            'id_cliente'  => 'nullable|exists:cliente,id_cliente',
        ]);

        $vehicle->update([
            'placa'       => strtoupper($validated['placa']),
            'propietario' => $validated['propietario'],
            'servicio'    => $validated['servicio'],
            'telefono'    => $validated['telefono'] ?? null,
            'modelo'      => $validated['modelo'] ?? null,
            'estado'      => $validated['estado'] ?? $vehicle->estado,
            'hora'        => $validated['hora'] ?? null,
            'id_cliente'  => $validated['id_cliente'] ?? null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Vehículo actualizado exitosamente.',
            'data'    => $vehicle,
        ], 200);
    }

    /**
     * DELETE /api/vehicles/{id}
     * Elimina un vehículo. Retorna 404 si no existe.
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehículo no encontrado.',
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'success' => true,
            'message' => 'Vehículo eliminado exitosamente.',
        ], 200);
    }

    /**
     * GET /api/vehicles/estado/{estado}
     * Ruta adicional: filtra vehículos por estado.
     * Ej: /api/vehicles/estado/Listo
     */
    public function porEstado($estado)
    {
        // Validar que el estado sea uno de los permitidos
        $estadosValidos = ['En espera', 'En proceso', 'Listo'];

        if (!in_array($estado, $estadosValidos)) {
            return response()->json([
                'success' => false,
                'message' => 'Estado no válido. Use: En espera, En proceso, Listo.',
            ], 422);
        }

        $vehicles = Vehicle::with('cliente')
            ->where('estado', $estado)
            ->get();

        return response()->json([
            'success' => true,
            'data'    => $vehicles,
            'total'   => $vehicles->count(),
            'estado'  => $estado,
        ], 200);
    }
}
