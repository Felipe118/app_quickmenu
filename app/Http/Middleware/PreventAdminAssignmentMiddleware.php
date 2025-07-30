<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventAdminAssignmentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->has('profile_id')) {
            return $next($request);
        }

        if (auth('api')->check() && auth('api')->user()->profile_id === 1) {
            return $next($request);
        }

        if($request->profile_id == 1) {
            return response()->json([
                'error' => 'Acesso negado'
            ], 403);
        }

        return $next($request);
    }
}
