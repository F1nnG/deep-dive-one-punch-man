<?php

namespace Database\Seeders;

use App\Models\Hero;
use App\Models\Power;
use App\Models\Statistic;
use Illuminate\Database\Seeder;

class HeroSeeder extends Seeder
{
    public function run(): void
    {
        $heroes = Hero::factory(10)->create();

        $heroes->each(function ($hero) {
            $hero->powers()->saveMany(
                Power::factory(3)->make([
                    'attack_type_id' => fake()->numberBetween(1, 15),
                ])
            );

            $hero->statistic()->save(
                Statistic::factory()->make()
            );
        });
    }
}
