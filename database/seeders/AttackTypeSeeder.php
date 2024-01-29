<?php

namespace Database\Seeders;

use App\Models\AttackType;
use Illuminate\Database\Seeder;

class AttackTypeSeeder extends Seeder
{
    public function run(): void
    {
        AttackType::factory(15)->create()->each(function ($attackType) {
            $attackType->update([
                'effective_against' => fake()->numberBetween(1, 15),
                'weak_against' => fake()->numberBetween(1, 15),
            ]);
        });
    }
}
