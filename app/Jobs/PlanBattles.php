<?php

namespace App\Jobs;

use App\Enums\Association;
use App\Models\Availability;
use App\Models\Battle;
use App\Models\BattleRequest;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class PlanBattles implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        foreach (BattleRequest::all() as $battle_request) {
            if (! BattleRequest::query()->where('id', $battle_request->id)->exists()) {
                return;
            }

            $battle = $this->planBattleFor($battle_request->user);

            if ($battle) {
                $battle_request->delete();

                if ($battle_request->user->id === $battle->hero->id) {
                    $battle->monster->battleRequests()->first()->delete();
                } else {
                    $battle->hero->battleRequests()->first()->delete();
                }
            }
        }
    }

    private function planBattleFor(User $user): ?Battle
    {
        $dates = $this->generateDates($user);
        $availability = Availability::getOverlappingWith($user, $dates);

        $battle = $this->createBattle($availability, $user, $dates);

        if ($battle) {
            $requester_availability = Availability::getFromUserWithDate($user, $battle->date);

            $requester_availability->removeDate($battle->date);
            $availability->removeDate($battle->date);
        }

        return $battle;
    }

    private function generateDates(User $user): Collection
    {
        /** @var Collection|Carbon[] $dates */
        $dates = $user->availabilities->map(function ($availability) {
            return $availability->period->toArray();
        })->flatten()->unique()->sort()->values();

        return $dates;
    }

    private function createBattle(?Availability $availability, User $user, Collection $dates): ?Battle
    {
        if (! $availability) {
            return null;
        }

        $date = $availability->getOverlappingDate($dates);

        if (! $date) {
            return null;
        }

        $userIds = [$user->id, $availability->user_id];
        [$hero_id, $monster_id] = $user->association === Association::Hero ? $userIds : array_reverse($userIds);

        return Battle::create([
            'hero_id' => $hero_id,
            'monster_id' => $monster_id,
            'date' => $date,
        ]);
    }
}
