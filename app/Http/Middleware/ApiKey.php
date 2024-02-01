<?php

namespace App\Http\Middleware;

use App\Models\ApiKey as ApiKeyModel;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     *
     * @throws Exception
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! ApiKeyModel::check($request->api_key ?? '')) {
            throw new Exception('Invalid API key', 403);
        }

        $request->merge(['apiKeyUser' => ApiKeyModel::where('key', $request->api_key)->first()->user]);

        return $next($request);
    }
}
