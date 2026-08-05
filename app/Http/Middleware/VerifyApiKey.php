<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $apiKey = $request->header('X-API-KEY');

        if (empty($apiKey)) {
            return response()->json([
                'status' => false,
                'message' => 'API Key is missing.'
            ], 401);
        }

        if ($apiKey !== config('services.dashboard.api_key')) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid API Key.'
            ], 401);
        }

        return $next($request);
    }
}