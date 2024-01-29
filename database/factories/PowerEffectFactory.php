<?php

namespace Database\Factories;

use App\Enums\Effectiveness;
use Illuminate\Database\Eloquent\Factories\Factory;

class PowerEffectFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'effectiveness' => fake()->randomElement(Effectiveness::cases()),
        ];
    }
}
