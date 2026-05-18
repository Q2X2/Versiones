<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // GET / — muestra el formulario de login
    public function index()
    {
        return view('index');
    }

    // POST /login — procesa el login
    public function login(Request $request)
    {
        $input = trim($request->login_input);

        if ($input === 'TurnosTrabajadores') {
            return redirect()->route('vehicles.index');
        }

        if (strlen($input) >= 6 && strlen($input) < 12) {
            // Placa del vehículo — redirige a registro
            return redirect()->route('vehicles.create');
        }

        if (strlen($input) < 6) {
            // Usuario corto — va a ver estado
            return redirect()->route('vehicles.index');
        }

        return back()->with('error', 'Entrada no válida. Intenta de nuevo.');
    }
}
