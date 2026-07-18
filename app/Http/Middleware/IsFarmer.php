<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsFarmer
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user || $user->role !== 'farmer') {
            return response()->json(['message' => 'Forbidden — farmer access required.'], 403);
        }

        return $next($request);
    }
}