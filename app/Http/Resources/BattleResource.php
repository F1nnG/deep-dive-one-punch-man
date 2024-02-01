<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $date
 * @property Carbon $finished_at
 * @property array $logs
 *
 * @property User $hero
 * @property User $monster
 * @property User $winner
 */
class BattleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hero' => new UserResource($this->hero),
            'monster' => new UserResource($this->monster),
            'date' => $this->date,
            'finished_at' => $this->finished_at,
            'winner' => new UserResource($this->winner),
            'logs' => $this->logs,
        ];
    }
}
