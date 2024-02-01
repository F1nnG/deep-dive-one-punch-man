<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BattleRequestController extends Controller
{
    public function create(Request $request): JsonResponse
    {
        $request->apiKeyUser->battleRequests()->create();

        return response()->json([
            'message' => 'Battle request created successfully',
        ], 200);
    }
}
