<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('battles', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'hero_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'monster_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignIdFor(User::class, 'winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->date('date');
            $table->dateTime('finished_at')->nullable();
            $table->json('logs')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battles');
    }
};
