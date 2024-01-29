<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection|Power[] $powers
 * @property Collection|PowerEffect[] $powerEffect
 */
class SkillType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function powers(): HasMany
    {
        return $this->hasMany(Power::class);
    }

    public function powerEffect(): HasMany
    {
        return $this->hasMany(PowerEffect::class);
    }
}
