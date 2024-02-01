<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StatisticResource;
use App\Models\Statistic;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class StatisticsController extends Controller
{
    public function index(): AnonymousResourceCollection
    {
        $statistics = Statistic::orderBy('elo', 'desc')
            ->limit(10)
            ->get();

        return StatisticResource::collection($statistics);
    }

    public function show(User $user): StatisticResource
    {
        return new StatisticResource($user->statistic);
    }
}
