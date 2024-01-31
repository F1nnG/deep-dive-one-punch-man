<?php

namespace App\Models;

use App\Models\Traits\HasPeriod;
use App\Queries\AvailabilityQuery;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property Carbon $start_date
 * @property Carbon $end_date
 *
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $user
 *
 * @property-read CarbonPeriod period
 *
 * @method AvailabilityQuery|static query()
 */
class Availability extends Model
{
    use HasFactory;
    use HasPeriod;

    protected $fillable = [
        'user_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function period(): Attribute
    {
        return Attribute::make(
            get: fn () => CarbonPeriod::create($this->start_date, $this->end_date),
        );
    }

    public function newEloquentBuilder($query): AvailabilityQuery
    {
        return new AvailabilityQuery($query);
    }
}
