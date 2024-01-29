<?php

namespace App\Models;

use App\Enums\Effectiveness;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $skill_type_id
 * @property int $power_id
 * @property string $name
 * @property Effectiveness $effectiveness
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property SkillType $skillType
 * @property Power $power
 */
class PowerEffect extends Model
{
    use HasFactory;

    protected $fillable = [
        'skill_type_id',
        'power_id',
        'name',
        'effectiveness',
    ];

    protected $casts = [
        'effectiveness' => Effectiveness::class,
    ];

    public function skillType(): BelongsTo
    {
        return $this->belongsTo(SkillType::class);
    }

    public function power(): BelongsTo
    {
        return $this->belongsTo(Power::class);
    }
}
