<?php

namespace Database\Seeders;

use App\Models\SkillType;
use Illuminate\Database\Seeder;

class SkillTypeSeeder extends Seeder
{
    public function run(): void
    {
        SkillType::factory(15)->create();
    }
}
