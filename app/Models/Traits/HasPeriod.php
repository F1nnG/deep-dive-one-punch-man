<?php

namespace App\Models\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

trait HasPeriod
{
    public function getOverlappingDate(Collection $dates): ?Carbon
    {
        foreach ($dates as $date) {
            if ($this->period->contains($date)) {
                return $date;
            }
        }
        return null;
    }
}
