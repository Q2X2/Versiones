<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Título dinámico según la página --}}
    <title inertia>Rueda Verde</title>

    {{-- Scripts de Inertia y Vite (React + CSS) --}}
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
    @inertiaHead
</head>
<body class="antialiased bg-gray-50">
    {{-- Punto de montaje de React via Inertia --}}
    @inertia
</body>
</html>
