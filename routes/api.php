<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VehicleApiController;
use App\Http\Controllers\Api\ClienteApiController;

/*
|--------------------------------------------------------------------------
| API Routes — Rueda Verde Autolavado
|--------------------------------------------------------------------------
| Rutas API REST consumibles por aplicaciones externas (móvil, web, etc.)
| Todas retornan JSON. CORS habilitado en config/cors.php.
|
| Base URL: /api/
| Estándar: REST (GET, POST, PUT, DELETE) con códigos HTTP correctos
*/

/*
|--------------------------------------------------------------------------
| Endpoint de estado de la API
|--------------------------------------------------------------------------
| GET /api → Verifica que la API está activa
*/
Route::get('/', function () {
    return response()->json([
        'success'  => true,
        'app'      => 'Rueda Verde API',
        'version'  => '1.0',
        'message'  => 'API REST funcionando correctamente.',
        'endpoints' => [
            'vehicles' => '/api/vehicles',
            'clientes' => '/api/clientes',
        ],
    ]);
});

/*
|--------------------------------------------------------------------------
| CRUD Vehículos — Rutas estándar REST
|--------------------------------------------------------------------------
| GET    /api/vehicles           → lista todos los vehículos
| POST   /api/vehicles           → crea un vehículo
| GET    /api/vehicles/{id}      → detalle de un vehículo
| PUT    /api/vehicles/{id}      → actualiza un vehículo
| DELETE /api/vehicles/{id}      → elimina un vehículo
*/
/*
|--------------------------------------------------------------------------
| Rutas adicionales de Vehículos
|--------------------------------------------------------------------------
| GET /api/vehicles/estado/{estado} → filtra por estado
| IMPORTANTE: debe ir ANTES de apiResource para no ser capturada como {vehicle}
| Ejemplo: /api/vehicles/estado/Listo
*/
Route::get('vehicles/estado/{estado}', [VehicleApiController::class, 'porEstado']);

Route::apiResource('vehicles', VehicleApiController::class);

/*
|--------------------------------------------------------------------------
| CRUD Clientes — Rutas estándar REST
|--------------------------------------------------------------------------
| GET    /api/clientes           → lista todos los clientes
| POST   /api/clientes           → crea un cliente
| GET    /api/clientes/{id}      → detalle de un cliente
| PUT    /api/clientes/{id}      → actualiza un cliente
| DELETE /api/clientes/{id}      → elimina un cliente
*/
Route::apiResource('clientes', ClienteApiController::class);

/*
|--------------------------------------------------------------------------
| Rutas adicionales de Clientes
|--------------------------------------------------------------------------
| GET /api/clientes/{id}/vehiculos → todos los vehículos de un cliente
*/
Route::get('clientes/{id}/vehiculos', [ClienteApiController::class, 'vehiculos']);
