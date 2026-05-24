<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/**
 * Rutas de autenticación — Laravel Breeze
 *
 * Define las rutas para registro, login, logout y recuperación
 * de contraseña. Se incluyen desde web.php con require.
 *
 * Rutas disponibles:
 * GET  /register          → Formulario de registro
 * POST /register          → Crear cuenta
 * GET  /login             → Formulario de inicio de sesión
 * POST /login             → Autenticar usuario
 * DELETE /logout          → Cerrar sesión
 * GET  /forgot-password   → Solicitar recuperación
 * POST /forgot-password   → Enviar enlace
 * GET  /reset-password    → Formulario nueva contraseña
 * POST /reset-password    → Guardar nueva contraseña
 */

// --- Rutas accesibles solo para invitados (no autenticados) ---
Route::middleware('guest')->group(function () {
    // Registro de nuevos usuarios
    Route::get('register', [RegisteredUserController::class, 'create'])
        ->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);

    // Inicio de sesión
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    // Recuperación de contraseña
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    // Restablecer contraseña con token
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

// --- Rutas accesibles solo para autenticados ---
Route::middleware('auth')->group(function () {
    // Cierre de sesión
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
