<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * Define el estado por defecto del modelo.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            // Genera un código numérico único de 6 dígitos
            'codigo_cliente' => fake()->unique()->numerify('######'), 
            'password' => static::$password ??= Hash::make('password'),
            'role' => fake()->randomElement(['admin', 'invitado']),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Estado para forzar un usuario administrador.
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    /**
     * Estado para forzar un usuario invitado.
     */
    public function invitado(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'invitado',
        ]);
    }
}