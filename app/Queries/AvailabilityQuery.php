<?php

namespace App\Queries;

use App\Enums\Association;
use App\Models\Availability;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class AvailabilityQuery extends Builder
{
    public function getOverlappingWith(User $user, Collection $dates): ?Availability
    {
        return Availability::whereUserAssociationNot($user->association)
            ->whereNot('user_id', $user->id)
            ->whereHasDateIn($dates)
            ->first();
    }

    public function whereUserAssociationNot(Association $association): self
    {
        return $this->whereHas('user', function (Builder $query) use ($association) {
            $query->whereNot('association', $association);
        });
    }

    public function whereHasDateIn(Collection $dates): self
    {
        return $this->where(function (Builder $query) use ($dates) {
            $dates->each(function (Carbon $date) use ($query) {
                $query->orWhere(function ($query) use ($date) {
                    $query->where('start_date', '<=', $date)
                        ->where('end_date', '>=', $date);
                });
            });
        });
    }
}
