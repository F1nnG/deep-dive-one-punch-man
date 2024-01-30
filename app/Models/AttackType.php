<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $effective_against
 * @property int $weak_against
 * @property int $damage
 *
 * @property Collection|Power[] $powers
 * @property AttackType $effectiveAgainst
 * @property AttackType $weakAgainst
 */
class AttackType extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'description',
        'effective_against',
        'weak_against',
        'damage'
    ];

    public function powers(): HasMany
    {
        return $this->hasMany(Power::class);
    }

    public function effectiveAgainst(): BelongsTo
    {
        return $this->belongsTo(AttackType::class, 'id', 'effective_against');
    }

    public function weakAgainst(): BelongsTo
    {
        return $this->belongsTo(AttackType::class, 'id', 'weak_against');
    }
}
