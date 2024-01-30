<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BattleRequest\CreateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class BattleRequestController extends Controller
{
    public function create(CreateRequest $request): JsonResponse
    {
        User::find($request->user_id)->battleRequests()->create();

        return response()->json([
            'message' => 'Battle request created successfully',
        ]);
    }
}
