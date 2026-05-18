TOMASHERNANDEZPADILLA_AA2_EV02
==============================
Proyecto: Rueda Verde — Módulo web funcional Laravel

REQUISITOS CUMPLIDOS
--------------------
✔ Módulo web funcional con formularios HTML
✔ Conexión backend: rutas y controladores (Laravel)
✔ Métodos GET y POST
✔ Vistas Blade para renderizar HTML
✔ Versionado con Git
✔ Diseño front-end original integrado (CSS, fuentes, imágenes)

ESTRUCTURA DEL PROYECTO
-----------------------
app/Http/Controllers/
  LoginController.php     — GET / (login), POST /login
  VehicleController.php   — CRUD completo de vehículos

app/Models/
  Vehicle.php             — Modelo tabla 'vehiculo'

database/migrations/
  ..._create_vehicles_table.php — Migración tabla vehiculo

resources/views/
  layouts/app.blade.php   — Layout principal
  index.blade.php         — Pantalla de login
  vehicles/
    index.blade.php       — Lista de turnos
    create.blade.php      — Formulario registro
    edit.blade.php        — Formulario edición
    show.blade.php        — Estado del vehículo

routes/web.php            — Todas las rutas GET/POST/PUT/DELETE

public/
  css/    — Estilos del front-end
  fonts/  — Fuente Inter
  img/    — Logo y carro
  js/     — app.js

CONFIGURACIÓN (ajustar .env)
-----------------------------
DB_DATABASE=autolavado
DB_USERNAME=root
DB_PASSWORD=Server

COMANDOS PARA CORRER
--------------------
composer install
php artisan migrate
php artisan serve


RUTAS DISPONIBLES
-----------------
GET  /                    → Login
POST /login               → Procesar login
GET  /vehicles            → Lista vehículos (turnos)
GET  /vehicles/create     → Formulario registro
POST /vehicles            → Guardar vehículo
GET  /vehicles/{id}       → Ver estado
GET  /vehicles/{id}/edit  → Formulario edición
PUT  /vehicles/{id}       → Actualizar vehículo
DELETE /vehicles/{id}     → Eliminar vehículo

Link Github: https://github.com/Q2X2/Versiones.git