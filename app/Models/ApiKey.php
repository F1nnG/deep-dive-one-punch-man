<?php

namespace App\Models;

use App\Models\Traits\HasAcceptedApiCheck;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property string $key
 * @property int $user_id
 * @property boolean $is_accepted
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $user
 *
 * @property-read string $field_content
 */
class ApiKey extends Model
{
    use HasFactory;
    use HasUuids;
    use HasAcceptedApiCheck;

    protected $primaryKey = 'key';

    protected $fillable = [
        'key',
        'user_id',
        'is_accepted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fieldContent(): Attribute
    {
        return Attribute::make(
            get: fn () => ($this->is_accepted ? $this->key : 'Pending'),
        );
    }
}
