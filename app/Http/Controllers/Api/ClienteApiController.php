<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cliente;

/**
 * ClienteApiController
 *
 * Controlador API REST para clientes del autolavado.
 * Expone endpoints JSON consumibles por cualquier aplicación externa.
 *
 * Base URL: /api/clientes
 * Estándar: REST con respuestas JSON y códigos HTTP correctos
 */
class ClienteApiController extends Controller
{
    /**
     * GET /api/clientes
     * Retorna lista completa de clientes con sus vehículos.
     */
    public function index()
    {
        $clientes = Cliente::with('vehiculos')->get();

        return response()->json([
            'success' => true,
            'data'    => $clientes,
            'total'   => $clientes->count(),
        ], 200);
    }

    /**
     * POST /api/clientes
     * Crea un nuevo cliente. Recibe y retorna JSON.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:100|unique:cliente,correo',
        ]);

        $cliente = Cliente::create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cliente registrado exitosamente.',
            'data'    => $cliente,
        ], 201);
    }

    /**
     * GET /api/clientes/{id}
     * Retorna el detalle de un cliente con sus vehículos.
     */
    public function show($id)
    {
        $cliente = Cliente::with('vehiculos')->find($id);

        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $cliente,
        ], 200);
    }

    /**
     * PUT /api/clientes/{id}
     * Actualiza un cliente existente.
     */
    public function update(Request $request, $id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        $validated = $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:100|unique:cliente,correo,' . $id . ',id_cliente',
        ]);

        $cliente->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'Cliente actualizado exitosamente.',
            'data'    => $cliente,
        ], 200);
    }

    /**
     * DELETE /api/clientes/{id}
     * Elimina un cliente. Retorna 404 si no existe.
     */
    public function destroy($id)
    {
        $cliente = Cliente::find($id);

        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        $cliente->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente eliminado exitosamente.',
        ], 200);
    }

    /**
     * GET /api/clientes/{id}/vehiculos
     * Ruta adicional: retorna todos los vehículos de un cliente específico.
     */
    public function vehiculos($id)
    {
        $cliente = Cliente::with('vehiculos')->find($id);

        if (!$cliente) {
            return response()->json([
                'success' => false,
                'message' => 'Cliente no encontrado.',
            ], 404);
        }

        return response()->json([
            'success'   => true,
            'cliente'   => $cliente->nombre,
            'data'      => $cliente->vehiculos,
            'total'     => $cliente->vehiculos->count(),
        ], 200);
    }
}
