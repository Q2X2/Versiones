<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DashboardController;

/*
|--------------------------------------------------------------------------
| Rutas Web - Rueda Verde Autolavado (React + Inertia + Laravel Breeze)
|--------------------------------------------------------------------------
| Las rutas de autenticación (login, register, logout, etc.) se
| definen en routes/auth.php e incluidas al final de este archivo.
|
| Las rutas del sistema (dashboard, vehículos, clientes) están protegidas
| con el middleware 'auth' de Laravel Breeze.
*/

// --- Ruta raíz → redirige al login de Breeze ---
Route::get('/', function () {
    return redirect()->route('login');
});

// --- Rutas protegidas por autenticación (Laravel Breeze) ---
Route::middleware(['auth'])->group(function () {

    // Dashboard principal con estadísticas y explorador de API
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // CRUD Vehículos (Inertia → React)
    Route::resource('vehicles', VehicleController::class);

    // CRUD Clientes (Inertia → React)
    Route::resource('clientes', ClienteController::class);
});

// --- Rutas de autenticación generadas por Laravel Breeze ---
require __DIR__.'/auth.php';
