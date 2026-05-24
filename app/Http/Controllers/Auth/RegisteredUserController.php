<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

/**
 * RegisteredUserController — Laravel Breeze
 *
 * Maneja el registro de nuevos usuarios trabajadores del sistema.
 * Usa el modelo User estándar de Laravel con contraseña hasheada.
 */
class RegisteredUserController extends Controller
{
    /**
     * GET /register
     * Muestra el formulario de registro React via Inertia.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Register');
    }

    /**
     * POST /register
     * Crea un nuevo usuario, inicia sesión y redirige al dashboard.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
