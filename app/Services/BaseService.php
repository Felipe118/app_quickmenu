<?php 

namespace App\Services;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;

abstract class BaseService
{
    /**
     * Verifica se o usuário é admin master ou dono do restaurante
     * @param User $user
     * @param int $restaurant_id
     * @return void
     */
    protected function ensureAdminMasterOrRestaurantOwner(User $user,int $restaurant_id) :void
    {
        if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
            return;
        }
        
        if($user->restaurants()->where('restaurant_id', $restaurant_id)->exists()){
           return;
        }

        throw new AuthorizationException('Acesso negado', 403);
    }   
}