<?php

namespace Database\Seeders;

use App\Enums\Association;
use App\Models\Availability;
use App\Models\BattleRequest;
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

        User::factory(10)->create();

        $users = User::all();

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

            $user->battleRequests()->saveMany(
                BattleRequest::factory(3)->make()
            );

            $user->availabilities()->saveMany(
                Availability::factory(5)->make()
            );
        });
    }
}
