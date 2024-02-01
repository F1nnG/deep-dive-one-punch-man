<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ApiKeyFactory extends Factory
{
    public function definition(): array
    {
        return [
            'key' => $this->faker->uuid,
            'is_accepted' => $this->faker->boolean,
        ];
    }
}
