<?php

namespace App\Models;

use App\Enums\Grade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $hero_id
 * @property int $attack_type_id
 * @property Grade $grade
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Hero $hero
 * @property AttackType $attackType
 */
class Power extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_id',
        'attack_type_id',
        'grade',
    ];

    protected $casts = [
        'grade' => Grade::class,
    ];

    public function hero(): BelongsTo
    {
        return $this->belongsTo(Hero::class);
    }

    public function attackType(): BelongsTo
    {
        return $this->belongsTo(AttackType::class);
    }
}
