<?php

namespace App\Models;

use App\Enums\Rating;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int id
 * @property int user_id
 * @property int elo
 * @property int wins
 * @property int losses
 * @property int draws
 *
 * @property Carbon created_at
 * @property Carbon updated_at
 *
 * @property User hero
 *
 * @property-read Rating rating
 */
class Statistic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function rating(): Attribute
    {
        return Attribute::make(
            get: fn () => Rating::calculate($this->elo),
        );
    }
}
