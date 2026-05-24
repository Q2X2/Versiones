<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * UserFactory — Fábrica de usuarios para pruebas
 *
 * Genera usuarios de prueba con datos falsos realistas.
 * Usada por los tests de autenticación (AuthTest).
 *
 * Uso en tests:
 *   $user = User::factory()->create();
 *   $user = User::factory()->create(['email' => 'correo@test.com']);
 *
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * La contraseña usada por la fábrica (en hash una sola vez).
     */
    protected static ?string $password;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'              => fake()->name(),
            'email'             => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password'          => static::$password ??= Hash::make('password'),
            'remember_token'    => Str::random(10),
        ];
    }

    /**
     * Estado: usuario con email sin verificar.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
