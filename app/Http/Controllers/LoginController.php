<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * LoginController
 * 
 * Controlador para la pantalla de inicio de sesión.
 * Redirige al usuario según el tipo de entrada ingresada.
 */
class LoginController extends Controller
{
    /**
     * GET /
     * Muestra la pantalla de login.
     */
    public function index()
    {
        return view('index');
    }

    /**
     * POST /login
     * Procesa el login y redirige según el tipo de usuario:
     * - "TurnosTrabajadores" → lista de vehículos (trabajador)
     * - 6-11 caracteres     → formulario de registro de vehículo (cliente con placa)
     * - menos de 6          → lista de vehículos (cliente)
     */
    public function login(Request $request)
    {
        // Limpiar espacios del input
        $input = trim($request->login_input);

        // Validar que el campo no esté vacío
        if (empty($input)) {
            return back()->with('error', 'Por favor ingresa un usuario o placa.');
        }

        // Acceso de trabajador con clave especial
        if ($input === 'TurnosTrabajadores') {
            return redirect()->route('vehicles.index');
        }

        // Placa de vehículo (entre 6 y 11 caracteres)
        if (strlen($input) >= 6 && strlen($input) < 12) {
            return redirect()->route('vehicles.create');
        }

        // Usuario corto (menos de 6 caracteres) → ver turnos
        if (strlen($input) < 6) {
            return redirect()->route('vehicles.index');
        }

        // Entrada no reconocida
        return back()->with('error', 'Entrada no válida. Intenta de nuevo.');
    }
}
