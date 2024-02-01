<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $legal_name
 * @property string $alias
 * @property string $email
 * @property string $phone
 * @property Carbon $date_of_birth
 * @property string $backstory
 * @property string $motivation
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'legal_name' => $this->legal_name,
            'alias' => $this->alias,
            'email' => $this->email,
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'backstory' => $this->backstory,
            'motivation' => $this->motivation,
        ];
    }
}
