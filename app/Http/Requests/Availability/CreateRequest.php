<?php

namespace App\Http\Requests\Availability;

use App\Http\Requests\FormRequest;
use App\Rules\OverlappingDates;

class CreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'start_date' => ['required', 'date', new OverlappingDates()],
            'end_date' => ['required', 'date', new OverlappingDates()],
        ];
    }

    public function messages(): array
    {
        return [
            'start_date.required' => 'Start date is required',
            'start_date.date' => 'Start date must be a date',
            'end_date.required' => 'End date is required',
            'end_date.date' => 'End date must be a date',
        ];
    }
}
