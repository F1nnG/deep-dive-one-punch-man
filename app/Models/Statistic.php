<?php

namespace App\Models;

use App\Enums\HeroClass;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property int hero_id
 * @property int elo
 * @property int wins
 * @property int losses
 * @property int draws
 *
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property Hero hero
 *
 * @property-read  HeroClass hero_class
 */
class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_id',
        'elo',
        'wins',
        'losses',
        'draws',
    ];

    protected $attributes = [
        'elo' => 1200,
        'wins' => 0,
        'losses' => 0,
        'draws' => 0,
    ];

    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }

    public function heroClass(): Attribute
    {
        return Attribute::make(
            get: fn () => HeroClass::calculate($this->elo),
        );
    }
}
