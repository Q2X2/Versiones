<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * AuthTest — Pruebas de inicio de sesión y registro (Laravel Breeze)
 *
 * Valida el flujo completo de autenticación:
 * - Registro de nuevo usuario
 * - Inicio de sesión con credenciales válidas
 * - Rechazo de credenciales inválidas
 * - Cierre de sesión
 *
 * Para ejecutar:
 *   php artisan test --filter AuthTest
 *   php artisan test tests/Feature/AuthTest.php
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────
    // 1. INICIO DE SESIÓN
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: un usuario puede iniciar sesión con credenciales correctas.
     *
     * Crea un usuario en la BD, envía POST /login con sus credenciales
     * y verifica que es autenticado y redirigido al dashboard.
     */
    public function test_usuario_puede_iniciar_sesion(): void
    {
        $user = User::factory()->create([
            'email'    => 'trabajador@ruedaverde.com',
            'password' => bcrypt('password123'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'trabajador@ruedaverde.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Prueba: no se puede iniciar sesión con contraseña incorrecta.
     *
     * Verifica que las credenciales inválidas retornan error de validación
     * y el usuario permanece como invitado.
     */
    public function test_no_puede_iniciar_sesion_con_credenciales_invalidas(): void
    {
        User::factory()->create([
            'email'    => 'correcto@mail.com',
            'password' => bcrypt('contrasenacorrecta'),
        ]);

        $response = $this->post('/login', [
            'email'    => 'correcto@mail.com',
            'password' => 'contrasenaincorrecta',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Prueba: no se puede iniciar sesión con email inexistente.
     */
    public function test_no_puede_iniciar_sesion_con_email_inexistente(): void
    {
        $response = $this->post('/login', [
            'email'    => 'noexiste@mail.com',
            'password' => 'cualquierpass',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /**
     * Prueba: el formulario de login es accesible como invitado.
     */
    public function test_pagina_login_es_accesible(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    // ─────────────────────────────────────────────────────────
    // 2. REGISTRO
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: se puede registrar un nuevo usuario trabajador.
     *
     * Envía POST /register con datos válidos y verifica que el usuario
     * es creado, autenticado y redirigido al dashboard.
     */
    public function test_se_puede_registrar_un_nuevo_usuario(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Nuevo Trabajador',
            'email'                 => 'nuevo@ruedaverde.com',
            'password'              => 'Segura1234!',
            'password_confirmation' => 'Segura1234!',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'nuevo@ruedaverde.com',
            'name'  => 'Nuevo Trabajador',
        ]);
    }

    /**
     * Prueba: no se puede registrar con correo ya existente.
     */
    public function test_no_puede_registrar_con_correo_duplicado(): void
    {
        User::factory()->create(['email' => 'duplicado@mail.com']);

        $response = $this->post('/register', [
            'name'                  => 'Otro',
            'email'                 => 'duplicado@mail.com',
            'password'              => 'Segura1234!',
            'password_confirmation' => 'Segura1234!',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /**
     * Prueba: no se puede registrar con contraseñas que no coinciden.
     */
    public function test_no_puede_registrar_si_contrasenas_no_coinciden(): void
    {
        $response = $this->post('/register', [
            'name'                  => 'Test',
            'email'                 => 'test@mail.com',
            'password'              => 'Segura1234!',
            'password_confirmation' => 'DiferenteClave!',
        ]);

        $response->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    // ─────────────────────────────────────────────────────────
    // 3. CIERRE DE SESIÓN
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: un usuario autenticado puede cerrar sesión.
     */
    public function test_usuario_autenticado_puede_cerrar_sesion(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertRedirect('/');
        $this->assertGuest();
    }

    // ─────────────────────────────────────────────────────────
    // 4. PROTECCIÓN DE RUTAS
    // ─────────────────────────────────────────────────────────

    /**
     * Prueba: el dashboard está protegido y redirige a login si no hay sesión.
     */
    public function test_dashboard_redirige_a_login_si_no_autenticado(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect('/login');
    }

    /**
     * Prueba: usuario autenticado accede al dashboard correctamente.
     */
    public function test_usuario_autenticado_accede_al_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');
        $response->assertStatus(200);
    }
}
