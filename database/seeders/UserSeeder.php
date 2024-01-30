<?php

namespace Database\Seeders;

use App\Enums\Association;
use App\Models\MatchRequest;
use App\Models\Power;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'legal_name' => 'Hero Hero',
            'alias' => 'Hero',
            'email' => 'hero@hero.com',
            'password' => 'hero',
            'association' => Association::Hero,
        ]);

        User::factory()->create([
            'legal_name' => 'Monster Monster',
            'alias' => 'Monster',
            'email' => 'monster@monster.com',
            'password' => 'monster',
            'association' => Association::Monster,
        ]);

        $users = User::factory(10)->create();

        $users->each(function ($user) {
            $user->powers()->saveMany(
                Power::factory(3)->make([
                    'attack_type_id' => 1,
                ])->each(function ($power) {
                    $power->attackType()->associate(fake()->numberBetween(1, 30));
                })
            );

            $user->statistic()->save(
                Statistic::factory()->make()
            );

            $user->match_requests()->saveMany(
                MatchRequest::factory(3)->make()
            );
        });
    }
}
