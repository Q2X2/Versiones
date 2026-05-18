TOMASHERNANDEZPADILLA_AA3_EV02
==============================
Proyecto: Rueda Verde — Autolavado
Actividad: AA3-EV02 Módulos codificados y probados

REQUISITOS CUMPLIDOS
--------------------
✔ CRUD completo para mínimo 2 modelos relacionados (Vehicle y Cliente)
✔ Validación de formularios con mensajes de error en español
✔ Mensajes flash de éxito (crear, editar, eliminar)
✔ Versionado con Git con commits descriptivos
✔ Sin vendor/ ni node_modules/ en el ZIP


MODELOS
-------
1. Vehicle (vehiculo)  — CRUD completo de vehículos en turno
2. Cliente (cliente)   — CRUD completo de clientes del autolavado
   Relación: Un cliente tiene muchos vehículos (hasMany / belongsTo)

MENSAJES FLASH
--------------
- Vehículo registrado exitosamente.
- Vehículo actualizado exitosamente.
- Vehículo eliminado exitosamente.
- Cliente registrado exitosamente.
- Cliente actualizado exitosamente.
- Cliente eliminado exitosamente.

CONFIGURACIÓN (.env)
--------------------
DB_DATABASE=autolavado
DB_USERNAME=root
DB_PASSWORD=

COMANDOS
--------
composer install
php artisan migrate:fresh
php -S 127.0.0.1:8081 -t public

Abrir: http://127.0.0.1:8081
