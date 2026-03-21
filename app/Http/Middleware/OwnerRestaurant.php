<?php

namespace App\Http\Middleware;

use App\Enums\RoleEnum;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OwnerRestaurant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
             return $next($request);
        }
        
        $restaurantId = $request->header('x-restaurant-id');

        if (!$restaurantId) {
            abort(422, 'Restaurante ativo não informado');
        }
        
        $restaurant = $user->restaurants()->where('restaurant_id', $restaurantId)->first();
        dd($restaurant);

        if (!$restaurant) {
            abort(403, 'Você não tem permissão para acessar este restaurante');
        }

        $request->attributes->set('restaurant', $restaurant);

        return $next($request);
    }

}
