<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AttackTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->word() . ' ' . fake()->word(),
            'description' => fake()->paragraph(),
            'damage' => fake()->numberBetween(1, 10),
        ];
    }
}
