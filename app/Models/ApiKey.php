<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $key
 * @property int $user_id
 * @property boolean $is_accepted
 *
 * @property User $user
 */
class ApiKey extends Model
{
    use HasFactory;
    use HasUuids;

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
}
