<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

/**
 * AuthenticatedSessionController — Laravel Breeze
 *
 * Maneja el inicio y cierre de sesión con autenticación real.
 * Reemplaza el LoginController simple por autenticación basada
 * en sesiones de Laravel con la tabla users estándar.
 */
class AuthenticatedSessionController extends Controller
{
    /**
     * GET /login
     * Muestra el formulario de inicio de sesión React via Inertia.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * POST /login
     * Autentica al usuario con las credenciales proporcionadas.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * DELETE /logout
     * Cierra la sesión del usuario autenticado.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
