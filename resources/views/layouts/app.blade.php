<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rueda Verde</title>
    <link rel="stylesheet" href="/css/styles.css">
    @stack('styles')
</head>
<body>
<div class="app-container">
    @yield('content')
</div>
@stack('scripts')
</body>
</html>
