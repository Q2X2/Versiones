TOMASHERNANDEZPADILLA_AA4_EV03
==============================
Proyecto: Rueda Verde — Autolavado
Actividad: AA4-EV03 Componente frontend con React JS + Inertia


TECNOLOGÍAS
-----------
- Laravel 12 (Backend)
- React 18 (Frontend)
- Inertia.js v2 (Puente Laravel ↔ React, sin API REST)
- Vite (Bundler)
- TailwindCSS v4

REQUISITOS CUMPLIDOS
--------------------
✔ Frontend desarrollado con React JS
✔ Navegación funcional con Inertia Link (sin recargar página)
✔ Formularios login y registro con React
✔ Validaciones con $request->validate, errores inyectados en React
✔ Mensajes flash de éxito/error compartidos globalmente
✔ Soporte multi-idioma (lang/es/messages.php y lang/en/messages.php)
✔ Comentarios en todos los componentes y controladores
✔ Estándares: PascalCase en clases/componentes, snake_case en BD
✔ Sin vendor/ ni node_modules/ en el ZIP
✔ Versionado con Git

ESTRUCTURA REACT
----------------
resources/js/
  app.jsx                    → Punto de entrada Inertia + React
  Layouts/
    MainLayout.jsx           → Layout principal con header y flash
  Components/
    InputField.jsx           → Campo de formulario reutilizable
    FlashMessage.jsx         → Mensajes flash auto-ocultables
  Pages/
    Login.jsx                → Pantalla de login
    Vehicles/
      Index.jsx              → Lista de vehículos
      Create.jsx             → Formulario registro
      Edit.jsx               → Formulario edición
      Show.jsx               → Detalle del vehículo
    Clientes/
      Index.jsx              → Lista de clientes
      Create.jsx             → Formulario registro
      Edit.jsx               → Formulario edición

MULTI-IDIOMA
------------
lang/es/messages.php  → Traducciones en español
lang/en/messages.php  → Traducciones en inglés

INSTALACIÓN
-----------
composer install
npm install
npm run build
php artisan migrate:fresh
php artisan serve

O para desarrollo con hot-reload:
php artisan serve  (en una terminal)
npm run dev        (en otra terminal)

Abrir: http://localhost:8000
