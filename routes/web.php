<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LoginController;

/*
|--------------------------------------------------------------------------
| Rutas Web - Rueda Verde Autolavado
|--------------------------------------------------------------------------
| Aquí se registran todas las rutas web de la aplicación.
| Modelos: Vehicle (vehiculo) y Cliente (cliente)
*/

// --- Autenticación ---
Route::get('/', [LoginController::class, 'index'])->name('index');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// --- CRUD Vehículos ---
// GET    /vehicles          → index   (lista de turnos)
// GET    /vehicles/create   → create  (formulario registro)
// POST   /vehicles          → store   (guardar vehículo)
// GET    /vehicles/{id}     → show    (estado del vehículo)
// GET    /vehicles/{id}/edit → edit   (formulario edición)
// PUT    /vehicles/{id}     → update  (actualizar vehículo)
// DELETE /vehicles/{id}     → destroy (eliminar vehículo)
Route::resource('vehicles', VehicleController::class);

// --- CRUD Clientes ---
// GET    /clientes          → index   (lista de clientes)
// GET    /clientes/create   → create  (formulario registro)
// POST   /clientes          → store   (guardar cliente)
// GET    /clientes/{id}/edit → edit   (formulario edición)
// PUT    /clientes/{id}     → update  (actualizar cliente)
// DELETE /clientes/{id}     → destroy (eliminar cliente)
Route::resource('clientes', ClienteController::class);
