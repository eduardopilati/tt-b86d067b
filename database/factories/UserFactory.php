<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public const PASSWORD = 'Aa123456';

    protected static ?string $hashedPassword;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'password' => static::$hashedPassword ??= Hash::make(static::PASSWORD),
            'document' => fake()->cpf(false),
            'remember_token' => Str::random(10),
        ];
    }
}
