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
</head>
<body>

    {{-- Contenedor principal centrado (360px ancho móvil) --}}
    <div class="app-container">
        @yield('content')
    </div>

    {{-- Scripts específicos de cada vista --}}
    @stack('scripts')

</body>
</html>
