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
            ->whereUserHasRequest()
            ->whereHasDateIn($dates)
            ->first();
    }

    public function getFromUserWithDate(User $user, Carbon $date): ?Availability
    {
        return Availability::fromUser($user)
            ->whereHasDate($date)
            ->first();
    }

    public function whereUserAssociationNot(Association $association): self
    {
        return $this->whereHas('user', function (Builder $query) use ($association) {
            $query->whereNot('association', $association);
        });
    }

    public function whereUserHasRequest(): self
    {
        return $this->whereHas('user', function (Builder $query) {
            $query->whereHas('battleRequests');
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

    public function whereHasDate(Carbon $date): self
    {
        return $this->where(function (Builder $query) use ($date) {
            $query->where('start_date', '<=', $date)
                ->where('end_date', '>=', $date);
        });
    }

    public function fromUser(User $user): self
    {
        return $this->where('user_id', $user->id);
    }
}
