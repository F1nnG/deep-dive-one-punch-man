<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class HeroFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'legal_name' => fake()->name(),
            'hero_alias' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'password' => static::$password ??= Hash::make('password'),
            'date_of_birth' => fake()->date(),
            'backstory' => fake()->paragraph(),
            'email_verified_at' => now(),
            'remember_token' => fake()->randomNumber(),
        ];
    }
}
