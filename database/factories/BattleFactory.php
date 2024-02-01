<?php

namespace Database\Factories;

use App\Enums\Association;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class BattleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'hero_id' => User::inRandomOrder()->where('association', Association::Hero)->first()->id,
            'monster_id' => User::inRandomOrder()->where('association', Association::Monster)->first()->id,
            'date' => $this->faker->dateTimeBetween('-1 month', '1 month'),
        ];
    }
}
