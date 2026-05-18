<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Inertia\Inertia;

/**
 * ClienteController
 *
 * Controlador CRUD para clientes del autolavado.
 * Retorna respuestas Inertia (React) en lugar de Blade.
 */
class ClienteController extends Controller
{
    /**
     * GET /clientes
     * Retorna la página React Clientes/Index.
     */
    public function index()
    {
        $clientes = Cliente::with('vehiculos')->get();

        return Inertia::render('Clientes/Index', [
            'clientes' => $clientes,
        ]);
    }

    /**
     * GET /clientes/create
     * Retorna la página React Clientes/Create.
     */
    public function create()
    {
        return Inertia::render('Clientes/Create');
    }

    /**
     * POST /clientes
     * Valida y guarda un nuevo cliente.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'correo'   => 'nullable|email|max:100|unique:cliente,correo',
        ], [
            'nombre.required' => 'El nombre del cliente es obligatorio.',
            'correo.email'    => 'El correo electrónico no es válido.',
            'correo.unique'   => 'Este correo ya está registrado.',
        ]);

        Cliente::create([
            'nombre'   => $request->nombre,
            'telefono' => $request->telefono,
            'correo'   => $request->correo,
        ]);

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente registrado exitosamente.');
    }

    /**
     * GET /clientes/{id}/edit
     * Retorna la página React Clientes/Edit.
     */
    public function edit($id)
    {
        $cliente = Cliente::findOrFail($id);

        return Inertia::render('Clientes/Edit', [
            'cliente' => $cliente,
        ]);
    }

    /**
     * PUT /clientes/{id}
     * Valida y actualiza los datos del cliente.
     */
    public function update(Request $request, $id)
    {
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
        $cliente->update([
            'nombre'   => $request->nombre,
            'telefono' => $request->telefono,
            'correo'   => $request->correo,
        ]);

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

        return redirect()->route('clientes.index')
            ->with('success', 'Cliente eliminado exitosamente.');
    }
}
