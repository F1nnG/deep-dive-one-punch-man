<?php

namespace Database\Factories;

use App\Models\Statistic;
use Illuminate\Database\Eloquent\Factories\Factory;

class StatisticFactory extends Factory
{
    protected $model = Statistic::class;

    public function definition(): array
    {
        return [
            'elo' => fake()->numberBetween(500, 2000),
            'wins' => fake()->numberBetween(5, 25),
            'losses' => fake()->numberBetween(5, 25),
            'draws' => fake()->numberBetween(5, 25),
        ];
    }
}
