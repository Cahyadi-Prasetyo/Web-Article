<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apikey = $request->header('X-API-KEY');

        $validApikey = env('API_KEY'); 

        if (!$apikey || $apikey !== $validApikey) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return $next($request);
    }
}
