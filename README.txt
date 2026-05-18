TOMASHERNANDEZPADILLA_AA3_EV01
==============================
Proyecto: Rueda Verde — Autolavado
Actividad: AA3-EV01 Codificación de módulos stand-alone, web y móvil

REQUISITOS CUMPLIDOS
--------------------
✔ Aplicación web funcional con CRUD completo (2 modelos: Vehicle y Cliente)
✔ Integración front-end + back-end + base de datos
✔ Validación de formularios con mensajes de error en español
✔ Versionado con Git (commits descriptivos)
✔ Estándares de codificación (PascalCase en clases, snake_case en BD y variables)
✔ Comentarios en controladores, modelos, migraciones y vistas Blade
✔ Sin carpetas vendor/ ni node_modules/ en el ZIP


MODELOS
-------
1. Vehicle (vehiculo)    — CRUD completo de vehículos en turno
2. Cliente (cliente)     — CRUD completo de clientes del autolavado
   Relación: Un cliente tiene muchos vehículos (hasMany / belongsTo)

ESTRUCTURA
----------
app/Http/Controllers/
  LoginController.php    — GET / y POST /login
  VehicleController.php  — CRUD completo vehículos
  ClienteController.php  — CRUD completo clientes

app/Models/
  Vehicle.php            — Modelo vehiculo con relación a Cliente
  Cliente.php            — Modelo cliente con relación a Vehicle

database/migrations/
  ..._create_vehicles_table.php — Tablas: cliente y vehiculo

resources/views/
  layouts/app.blade.php  — Layout base
  index.blade.php        — Login
  vehicles/              — Vistas CRUD vehículos
  clientes/              — Vistas CRUD clientes

routes/web.php           — Rutas GET/POST/PUT/DELETE comentadas
public/css, fonts, img   — Assets del front-end

CONFIGURACIÓN (.env)
--------------------
DB_DATABASE=autolavado
DB_USERNAME=root
DB_PASSWORD=             ← vacío en XAMPP por defecto

COMANDOS
--------
composer install
php artisan migrate
php -S 127.0.0.1:8081 -t public

Abrir: http://127.0.0.1:8081

ACCESO
------
- "TurnosTrabajadores"     → lista de vehículos (trabajador)
- Texto 6-11 caracteres    → registrar vehículo (cliente)
- Texto menor a 6 chars    → ver turnos
