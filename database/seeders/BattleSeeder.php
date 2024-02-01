<?php

namespace Database\Seeders;

use App\Models\Battle;
use Illuminate\Database\Seeder;

class BattleSeeder extends Seeder
{
    public function run(): void
    {
        Battle::factory(30)->create();
    }
}
