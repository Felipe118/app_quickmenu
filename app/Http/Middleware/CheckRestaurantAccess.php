<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Restaurant;
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

        if (!$restaurant) {
            return $next($request);
        }

        // 🔥 Se ainda não for model (fallback)
        if (!$restaurant instanceof \App\Models\Restaurant) {
            $restaurant = Restaurant::where('id', $restaurant)
                ->orWhere('slug', $restaurant)
                ->firstOrFail();

            $request->route()->setParameter('restaurant', $restaurant);
        }

        if ($user->hasRole('admin_master')) {
            return $next($request);
        }

        if (!$user->restaurants()
            ->where('restaurant.id', $restaurant->id)
            ->exists()) {
            abort(403, 'Acesso não autorizado a este restaurante');
        }

        return $next($request);
    }
}
