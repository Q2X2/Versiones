<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;

/**
 * ClienteController
 *
 * Controlador CRUD para la gestión de clientes del autolavado.
 * Incluye mensajes flash de éxito y validación con mensajes en español.
 */
class ClienteController extends Controller
{
    /**
     * GET /clientes
     * Muestra la lista de todos los clientes registrados.
     */
    public function index()
    {
        // Obtener todos los clientes con sus vehículos relacionados
        $clientes = Cliente::with('vehiculos')->get();

        return view('clientes.index', compact('clientes'));
    }

    /**
     * GET /clientes/create
     * Muestra el formulario para registrar un nuevo cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * POST /clientes
     * Valida y guarda un nuevo cliente en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación con mensajes de error en español
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:100|unique:cliente,correo',
        ], [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'correo.email'    => 'El correo electrónico no es válido.',
            'correo.unique'   => 'Este correo ya está registrado.',
        ]);

        // Crear cliente con los datos validados
        Cliente::create([
            'nombre'   => $request->nombre,
            'telefono' => $request->telefono,
            'correo'   => $request->correo,
        ]);

        // Mensaje flash de éxito al crear
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente registrado exitosamente.');
    }

    /**
     * GET /clientes/{id}/edit
     * Muestra el formulario para editar un cliente existente.
     */
    public function edit($id)
    {
        // Buscar cliente o retornar 404
        $cliente = Cliente::findOrFail($id);

        return view('clientes.edit', compact('cliente'));
    }

    /**
     * PUT /clientes/{id}
     * Valida y actualiza los datos de un cliente existente.
     */
    public function update(Request $request, $id)
    {
        // Validación ignorando el correo del cliente actual (unique)
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:100|unique:cliente,correo,' . $id . ',id_cliente',
        ], [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'correo.email'    => 'El correo electrónico no es válido.',
            'correo.unique'   => 'Este correo ya está registrado.',
        ]);

        $cliente = Cliente::findOrFail($id);

        // Actualizar campos del cliente
        $cliente->update([
            'nombre'   => $request->nombre,
            'telefono' => $request->telefono,
            'correo'   => $request->correo,
        ]);

        // Mensaje flash de éxito al actualizar
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente actualizado exitosamente.');
    }

    /**
     * DELETE /clientes/{id}
     * Elimina un cliente de la base de datos.
     */
    public function destroy($id)
    {
        Cliente::destroy($id);

        // Mensaje flash de éxito al eliminar
        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
