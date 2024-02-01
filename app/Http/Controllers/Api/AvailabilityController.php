<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Availability\CreateRequest;
use App\Http\Resources\AvailabilityResource;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    public function create(CreateRequest $request)
    {
        $request->apiKeyUser->availabilities()->create([
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
        ]);

        return response()->json([
            'message' => 'Availability added successfully',
        ], 200);
    }

    public function index(Request $request)
    {
        $availabilities = $request->apiKeyUser->availabilities()
            ->orderBy('start_date')
            ->get();

        return AvailabilityResource::collection($availabilities);
    }
}
