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

    public function removeDate(Carbon $date): void
    {
        if ($date->isSameDay($this->start_date) && $date->isSameDay($this->end_date)) {
            $this->delete();
        } elseif ($date->isSameDay($this->start_date)) {
            $this->update([
                'start_date' => $date->addDay(),
            ]);
        } elseif ($date->isSameDay($this->end_date)) {
            $this->update([
                'end_date' => $date->subDay(),
            ]);
        } elseif ($this->period->contains($date)) {
            $this->update([
                'end_date' => $date->subDay(),
            ]);
            self::create([
                'user_id' => $this->user_id,
                'start_date' => $date->addDay(),
                'end_date' => $this->end_date,
            ]);
        }
    }
}
