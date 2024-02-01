<?php

namespace App\Rules;

use App\Models\Availability;
use Carbon\CarbonPeriod;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class OverlappingDates implements DataAwareRule, ValidationRule
{
    protected array $data = [];

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $availabilities = Auth::check()
            ? Auth::user()->availabilities
            : $this->data['apiKeyUser']->availabilities;

        $datesByUser = $availabilities
            ->except($this->data['id'] ?? null)
            ->map(fn (Availability $availability) => $availability->period);

        $validatingPeriod = CarbonPeriod::create($this->data['start_date'], $this->data['end_date']);

        if ($this->data['end_date'] < $this->data['start_date']) {
            $fail('The end date must be after the start date.');
        }

        $datesByUser->each(function (CarbonPeriod $period) use ($validatingPeriod, $fail) {
            if (
                $period->getEndDate()->eq($validatingPeriod->getStartDate()) ||
                $period->getStartDate()->eq($validatingPeriod->getEndDate()) ||
                $period->overlaps($validatingPeriod)
            ) {
                $fail('The dates overlap with other availabilities.');
            }
        });
    }

    public function setData(array $data): static
    {
        if (array_key_exists('data', $data)) {
            $this->data = $data['data'];
        } else {
            $this->data = $data;
        }

        return $this;
    }
}
