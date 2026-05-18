<?php

/**
 * cors.php — Configuración de CORS (Cross-Origin Resource Sharing)
 *
 * Permite que otras aplicaciones (móviles, frontend externo, Postman)
 * consuman la API REST de Rueda Verde desde cualquier origen.
 *
 * Estándar API REST: acceso abierto a rutas /api/*
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Rutas cubiertas por CORS
    |--------------------------------------------------------------------------
    | Se aplica CORS a todas las rutas que empiecen con api/
    */
    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    /*
    |--------------------------------------------------------------------------
    | Métodos HTTP permitidos
    |--------------------------------------------------------------------------
    | Se permiten todos los métodos del estándar REST
    */
    'allowed_methods' => ['*'],

    /*
    |--------------------------------------------------------------------------
    | Orígenes permitidos
    |--------------------------------------------------------------------------
    | '*' permite que cualquier aplicación externa consuma la API
    */
    'allowed_origins' => ['*'],

    'allowed_origins_patterns' => [],

    /*
    |--------------------------------------------------------------------------
    | Headers permitidos
    |--------------------------------------------------------------------------
    */
    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    /*
    |--------------------------------------------------------------------------
    | Max Age del preflight cache (segundos)
    |--------------------------------------------------------------------------
    */
    'max_age' => 0,

    /*
    |--------------------------------------------------------------------------
    | Soporte de credenciales (cookies, auth headers)
    |--------------------------------------------------------------------------
    */
    'supports_credentials' => false,

];
