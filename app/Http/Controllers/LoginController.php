<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

/**
 * LoginController
 *
 * Controlador de autenticación del autolavado.
 * Retorna la página React Login via Inertia.
 */
class LoginController extends Controller
{
    /**
     * GET /
     * Muestra la pantalla de login (componente React Login.jsx).
     */
    public function index()
    {
        return Inertia::render('Login');
    }

    /**
     * POST /login
     * Procesa el login y redirige según el tipo de usuario.
     */
    public function login(Request $request)
    {
        $input = trim($request->login_input);

        if (empty($input)) {
            return back()->withErrors(['login_input' => 'Por favor ingresa un usuario o placa.']);
        }

        // Acceso de trabajador con clave especial → Dashboard
        if ($input === 'TurnosTrabajadores') {
            return redirect()->route('dashboard');
        }

        // Placa del vehículo (6 a 11 caracteres)
        if (strlen($input) >= 6 && strlen($input) < 12) {
            return redirect()->route('vehicles.create');
        }

        // Usuario corto → ver turnos
        if (strlen($input) < 6) {
            return redirect()->route('vehicles.index');
        }

        return back()->withErrors(['login_input' => 'Entrada no válida. Intenta de nuevo.']);
    }
}
