TOMASHERNANDEZPADILLA_AA4_EV03
==============================
Proyecto: Rueda Verde — Autolavado
Actividad: AA4-EV03 Frontend React JS + API REST

TECNOLOGÍAS
-----------
- Laravel 12 (Backend)
- React 18 (Frontend)
- Inertia.js v2 (Puente Laravel ↔ React)
- API REST JSON (consumible por apps externas)
- CORS habilitado (config/cors.php)
- Vite + TailwindCSS v4

ESTRUCTURA API REST
-------------------
routes/api.php                          → Todas las rutas API
app/Http/Controllers/Api/
  VehicleApiController.php              → CRUD vehículos en JSON
  ClienteApiController.php             → CRUD clientes en JSON
config/cors.php                         → Configuración CORS

ENDPOINTS API
-------------
GET    /api/                            → Estado de la API
GET    /api/vehicles                    → Lista vehículos
POST   /api/vehicles                    → Crear vehículo
GET    /api/vehicles/{id}               → Detalle vehículo
PUT    /api/vehicles/{id}               → Actualizar vehículo
DELETE /api/vehicles/{id}               → Eliminar vehículo
GET    /api/vehicles/estado/{estado}    → Filtrar por estado (adicional)

GET    /api/clientes                    → Lista clientes
POST   /api/clientes                    → Crear cliente
GET    /api/clientes/{id}               → Detalle cliente
PUT    /api/clientes/{id}               → Actualizar cliente
DELETE /api/clientes/{id}               → Eliminar cliente
GET    /api/clientes/{id}/vehiculos     → Vehículos de un cliente (adicional)

INSTALACIÓN
-----------
composer install
npm install
npm run build
php artisan migrate:fresh
php artisan serve

Abrir: http://localhost:8000
API:   http://localhost:8000/api/vehicles
