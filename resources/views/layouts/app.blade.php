{{-- Layout Principal: app.blade.php --}}
{{-- Todas las vistas extienden este layout base --}}

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rueda Verde</title>

    {{-- Estilos globales de la aplicación --}}
    <link rel="stylesheet" href="/css/styles.css">

    {{-- Estilos específicos de cada vista --}}
    @stack('styles')

    <style>
        /* Estilos para mensajes flash */
        .flash-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 10px 15px;
            font-size: 14px;
            font-weight: 500;
        }
        .flash-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            padding: 12px 16px;
            margin: 10px 15px;
            font-size: 14px;
        }
    </style>
</head>
<body>

    {{-- Contenedor principal centrado (360px ancho móvil) --}}
    <div class="app-container">

        {{-- Mensaje flash de éxito (crear, editar, eliminar) --}}
        @if(session('success'))
            <div class="flash-success">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Mensaje flash de error general --}}
        @if(session('error'))
            <div class="flash-error">
                ❌ {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </div>

    {{-- Scripts específicos de cada vista --}}
    @stack('scripts')

</body>
</html>
