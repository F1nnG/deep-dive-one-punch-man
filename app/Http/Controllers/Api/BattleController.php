<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BattleResource;
use App\Models\Battle;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BattleController extends Controller
{
    public function index(User $user): AnonymousResourceCollection
    {
        return BattleResource::collection($user->battles);
    }

    public function show(Battle $battle): BattleResource
    {
        return new BattleResource($battle);
    }
}
