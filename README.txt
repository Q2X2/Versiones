TOMASHERNANDEZPADILLA_AA5_EV03
==============================

ENDPOINTS DISPONIBLES
---------------------
GET    /api                          → Estado de la API
GET    /api/vehicles                 → Lista vehículos
POST   /api/vehicles                 → Crear vehículo
GET    /api/vehicles/{id}            → Detalle vehículo
PUT    /api/vehicles/{id}            → Actualizar vehículo
DELETE /api/vehicles/{id}            → Eliminar vehículo
GET    /api/vehicles/estado/{estado} → Filtrar por estado

GET    /api/clientes                 → Lista clientes
POST   /api/clientes                 → Crear cliente
GET    /api/clientes/{id}            → Detalle cliente
PUT    /api/clientes/{id}            → Actualizar cliente
DELETE /api/clientes/{id}            → Eliminar cliente
GET    /api/clientes/{id}/vehiculos  → Vehículos de un cliente

INSTALACIÓN
-----------
composer install
npm install
npm run build
php artisan migrate:fresh
php artisan serve

API disponible en: http://localhost:8000/api
