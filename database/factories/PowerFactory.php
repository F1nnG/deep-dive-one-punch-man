<?php

namespace Database\Factories;

use App\Enums\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

class PowerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'grade' => fake()->randomElement(Grade::cases()),
        ];
    }
}
