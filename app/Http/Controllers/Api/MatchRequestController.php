<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MatchRequest\CreateRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class MatchRequestController extends Controller
{
    public function create(CreateRequest $request): JsonResponse
    {
        User::find($request->user_id)->match_requests()->create();

        return response()->json([
            'message' => 'Match request created successfully',
        ]);
    }
}
