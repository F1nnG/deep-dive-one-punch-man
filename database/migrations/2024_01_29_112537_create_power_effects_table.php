<?php

use App\Models\Power;
use App\Models\SkillType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('power_effects', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(SkillType::class)->constrained();
            $table->foreignIdFor(Power::class)->constrained();
            $table->string('name');
            $table->string('effectiveness');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('power_effects');
    }
};
