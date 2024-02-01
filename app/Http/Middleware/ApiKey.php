<?php

namespace App\Http\Middleware;

use App\Models\ApiKey as ApiKeyModel;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! ApiKeyModel::check($request->api_key)) {
            throw new Exception('Invalid API key', 403);
        }

        $request->merge(['apiKeyUser' => ApiKeyModel::whereKey($request->api_key)->first()->user]);

        return $next($request);
    }
}
