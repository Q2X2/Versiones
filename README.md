# 🟢 Rueda Verde — Sistema de Autolavado

**Proyecto:** GA8-AA1-EV01  
**Repositorio:** [https://github.com/Q2X2/Versiones](https://github.com/Q2X2/Versiones)  
**Stack:** Laravel 12 · React 18 · Inertia.js · Laravel Breeze · API REST

---

## 📋 Descripción

Sistema web para la gestión de turnos del autolavado **Rueda Verde**. Permite registrar vehículos con su servicio y estado, gestionar clientes, y consultar todo vía API REST. La autenticación real es manejada por **Laravel Breeze** con email y contraseña.

---

## ✅ Funcionalidades principales

| # | Funcionalidad | Ruta |
|---|---|---|
| 1 | Inicio de sesión (Laravel Breeze) | `GET /login` |
| 2 | Registro de usuarios trabajadores | `GET /register` |
| 3 | CRUD Vehículos (React + Inertia) | `GET /vehicles` |
| 4 | CRUD Clientes (React + Inertia) | `GET /clientes` |
| 5 | Dashboard con explorador de API | `GET /dashboard` |
| + | API REST completa (JSON) | `GET /api/vehicles`, `/api/clientes` |

---

## 🛠️ Requisitos

- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL (o SQLite para pruebas)
- npm

---

## 🚀 Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/Q2X2/Versiones.git
cd Versiones

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JavaScript
npm install

# 4. Configurar entorno
cp .env.example .env
php artisan key:generate

# 5. Configurar base de datos en .env
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=autolavado
# DB_USERNAME=root
# DB_PASSWORD=tu_password

# 6. Ejecutar migraciones
php artisan migrate

# 7. Compilar assets React
npm run build

# 8. Iniciar servidor
php artisan serve
```

Accede en: **http://localhost:8000**

---

## 🔐 Autenticación — Laravel Breeze

El sistema usa **Laravel Breeze** para autenticación real con email y contraseña.

### Rutas de autenticación

| Método | Ruta | Descripción |
|--------|------|-------------|
| GET | `/login` | Formulario de inicio de sesión |
| POST | `/login` | Autenticar usuario |
| GET | `/register` | Formulario de registro |
| POST | `/register` | Crear nueva cuenta |
| POST | `/logout` | Cerrar sesión |
| GET | `/forgot-password` | Recuperar contraseña |
| GET | `/reset-password/{token}` | Restablecer contraseña |

### Crear primer usuario

```bash
# Desde tinker
php artisan tinker
>>> \App\Models\User::create(['name'=>'Admin','email'=>'admin@ruedaverde.com','password'=>bcrypt('password')]);
```

---

## 🔌 API REST

**Base URL:** `/api/`

### Vehículos

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/vehicles` | Lista todos los vehículos |
| POST | `/api/vehicles` | Crea un vehículo |
| GET | `/api/vehicles/{id}` | Detalle de un vehículo |
| PUT | `/api/vehicles/{id}` | Actualiza un vehículo |
| DELETE | `/api/vehicles/{id}` | Elimina un vehículo |
| GET | `/api/vehicles/estado/{estado}` | Filtra por estado |

**Estados válidos:** `En espera` · `En proceso` · `Listo`

### Clientes

| Método | Endpoint | Descripción |
|--------|----------|-------------|
| GET | `/api/clientes` | Lista todos los clientes |
| POST | `/api/clientes` | Crea un cliente |
| GET | `/api/clientes/{id}` | Detalle de un cliente |
| PUT | `/api/clientes/{id}` | Actualiza un cliente |
| DELETE | `/api/clientes/{id}` | Elimina un cliente |
| GET | `/api/clientes/{id}/vehiculos` | Vehículos de un cliente |

---

## 🧪 Pruebas Unitarias (PHPUnit)

El proyecto incluye pruebas completas en `tests/Unit/` y `tests/Feature/`.

### Ejecutar todas las pruebas

```bash
php artisan test
```

### Ejecutar por archivo

```bash
# Pruebas unitarias del modelo Cliente
php artisan test tests/Unit/ClienteTest.php

# Pruebas unitarias del modelo Vehicle
php artisan test tests/Unit/VehicleTest.php

# Pruebas de autenticación (Laravel Breeze)
php artisan test tests/Feature/AuthTest.php

# Pruebas de la API REST
php artisan test tests/Feature/ApiTest.php
```

### Ejecutar por grupo

```bash
php artisan test --filter ClienteTest
php artisan test --filter VehicleTest
php artisan test --filter AuthTest
php artisan test --filter ApiTest
```

### Cobertura de pruebas

| Archivo | Clase | Pruebas |
|---------|-------|---------|
| `tests/Unit/ClienteTest.php` | `ClienteTest` | Registro, consulta, actualización, eliminación, relaciones de clientes |
| `tests/Unit/VehicleTest.php` | `VehicleTest` | Registro, consulta, filtros, actualización, eliminación de vehículos |
| `tests/Feature/AuthTest.php` | `AuthTest` | Login válido/inválido, registro, logout, protección de rutas |
| `tests/Feature/ApiTest.php` | `ApiTest` | Todos los endpoints GET/POST/PUT/DELETE de la API REST |

### Las pruebas validan

- ✅ Inicio de sesión (credenciales válidas e inválidas)
- ✅ Registro de clientes y usuarios
- ✅ Consulta de clientes y vehículos
- ✅ Registro de vehículos con campos opcionales
- ✅ Actualización de información (estado, datos personales)
- ✅ Eliminación de registros con verificación en BD
- ✅ Respuestas de la API (códigos HTTP, estructura JSON)

> Las pruebas usan **SQLite en memoria** (`:memory:`) — no afectan la base de datos de desarrollo.

---

## 📁 Estructura del proyecto

```
laravel-proyecto/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/                    ← Laravel Breeze
│   │   │   │   ├── AuthenticatedSessionController.php
│   │   │   │   ├── RegisteredUserController.php
│   │   │   │   ├── PasswordResetLinkController.php
│   │   │   │   └── NewPasswordController.php
│   │   │   ├── Api/
│   │   │   │   ├── VehicleApiController.php
│   │   │   │   └── ClienteApiController.php
│   │   │   ├── ClienteController.php
│   │   │   ├── VehicleController.php
│   │   │   └── DashboardController.php
│   │   ├── Middleware/
│   │   │   ├── HandleInertiaRequests.php
│   │   │   └── RedirectIfAuthenticated.php  ← Breeze
│   │   └── Requests/
│   │       └── Auth/
│   │           └── LoginRequest.php          ← Breeze
│   └── Models/
│       ├── User.php                          ← Breeze
│       ├── Cliente.php
│       └── Vehicle.php
├── database/
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php  ← Breeze
│   │   └── 2026_03_16_224506_create_vehicles_table.php
│   └── factories/
│       └── UserFactory.php
├── resources/js/
│   ├── Pages/
│   │   ├── Auth/                            ← Breeze React
│   │   │   ├── Login.jsx
│   │   │   ├── Register.jsx
│   │   │   └── ForgotPassword.jsx
│   │   ├── Clientes/
│   │   ├── Vehicles/
│   │   └── Dashboard.jsx
│   └── Layouts/
│       └── MainLayout.jsx
├── routes/
│   ├── web.php                              ← Protegido con auth
│   ├── auth.php                             ← Breeze routes
│   └── api.php
└── tests/
    ├── Unit/
    │   ├── ClienteTest.php
    │   └── VehicleTest.php
    └── Feature/
        ├── AuthTest.php
        └── ApiTest.php
```

---

## 🔗 Repositorio

[https://github.com/Q2X2/Versiones](https://github.com/Q2X2/Versiones)
