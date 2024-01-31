<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AvailabilityFactory extends Factory
{
    public function definition(): array
    {
        $start_date = fake()->dateTimeBetween('now', '+1 month')->format('Y-m-d');
        $end_date = fake()->dateTimeBetween($start_date, '+1 month')->format('Y-m-d');

        return [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
