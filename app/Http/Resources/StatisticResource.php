<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $elo
 * @property string $rating
 * @property int $wins
 * @property int $losses
 * @property int $draws
 *
 * @property User $user
 */
class StatisticResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'elo' => $this->elo,
            'rating' => $this->rating,
            'wins' => $this->wins,
            'losses' => $this->losses,
            'draws' => $this->draws,
            'user' => new UserResource($this->user),
        ];
    }
}
