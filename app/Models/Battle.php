<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int hero_id
 * @property int monster_id
 * @property Carbon $date
 * @property Carbon $finished_at
 * @property int $winner_id
 * @property array $logs
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $hero
 * @property User $monster
 * @property User $winner
 *
 * @property-read bool $finished
 * @property-read null|User $loser
 */
class Battle extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_id',
        'monster_id',
        'date',
        'finished_at',
        'winner_id',
        'logs',
    ];

    protected $casts = [
        'date' => 'date',
        'finished_at' => 'datetime',
        'logs' => 'array',
    ];

    public function hero(): BelongsTo
    {
        return $this->belongsTo(User::class, 'hero_id');
    }

    public function monster(): BelongsTo
    {
        return $this->belongsTo(User::class, 'monster_id');
    }

    public function winner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'winner_id');
    }

    public function finished(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->finished_at !== null,
        );
    }

    public function loser(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->finished) {
                    return $this->winner_id === $this->hero_id
                        ? $this->monster
                        : $this->hero;
                }
                return null;
            }
        );
    }
}
