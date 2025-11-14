<?php 

namespace App\Services;

use App\Enums\MessageEnum;
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
        if(
            !$user->restaurants()
                ->where('restaurant_id', $restaurant_id)->exists() &&
            !$user->hasRole(RoleEnum::ADMIM_MASTER->value)    
        ){
           throw new AuthorizationException(MessageEnum::ACESSO_NEGADO->value, 403);
        }        
    }
    
    protected function verifyUserHasRestaurant(int $user_id): bool
    {
        if(User::find($user_id)->restaurants()->where('user_id', $user_id)->exists()){
           return true;
        }

        if(User::find($user_id)->hasRole(RoleEnum::ADMIM_MASTER->value)){
            return true;
        }

        return false;
    }

    protected function verifyUserHasRole(User $user):void
    {
        if(!$user->hasRole(RoleEnum::ADMIM_MASTER->value)){
            throw new AuthorizationException(MessageEnum::ACESSO_NEGADO->value, 403);
        }
    }
}