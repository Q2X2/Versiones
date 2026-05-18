<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Rutas Web - Rueda Verde Autolavado (React + Inertia)
|--------------------------------------------------------------------------
| Todas las rutas retornan componentes React via Inertia::render().
| Los errores de validación se inyectan automáticamente en React.
*/

// --- Login ---
Route::get('/', [LoginController::class, 'index'])->name('index');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// --- CRUD Vehículos (Inertia → React) ---
Route::resource('vehicles', VehicleController::class);

// --- CRUD Clientes (Inertia → React) ---
Route::resource('clientes', ClienteController::class);
