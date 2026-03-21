<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRestaurantAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $restaurant = $request->route('restaurant');

        // Se NÃO tem restaurant na rota → só segue
        if (!$restaurant) {
            return $next($request);
        }

        dd($restaurant);
        //dd($user->restaurants());
        if (!$user->restaurants()->where('id', $restaurant->id)->exists()) {
            abort(403, 'Acesso não autorizado a este restaurante');
        }

        return $next($request);
    }
}
