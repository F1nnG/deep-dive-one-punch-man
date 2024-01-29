<?php

namespace Database\Seeders;

use App\Models\Hero;
use App\Models\Power;
use App\Models\PowerEffect;
use App\Models\SkillType;
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
                    'skill_type_id' => SkillType::wherebetween('id', [1, 15])->inRandomOrder()->first()->id,
                ])
            );

            $hero->powers()->each(function ($power) {
                $power->powerEffects()->saveMany(
                    PowerEffect::factory(3)->make([
                        'skill_type_id' => SkillType::wherebetween('id', [1, 15])->inRandomOrder()->first()->id,
                    ])
                );
            });

            $hero->statistic()->save(
                Statistic::factory()->make()
            );
        });
    }
}
