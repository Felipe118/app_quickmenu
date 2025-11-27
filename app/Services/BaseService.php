<?php 

namespace App\Services;

use App\Enums\MessageEnum;
use App\Enums\RoleEnum;
use App\Exceptions\SistemException;
use App\Models\User;
use Exception;
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
    
    protected function verifyUserHasRestaurant(int $user_id): void
    {
        if (
            User::find($user_id)->restaurants()->where('user_id', $user_id)->exists() ||
            User::find($user_id)->hasRole(RoleEnum::ADMIM_MASTER->value)
        ){
           return;
        }

        throw new SistemException(MessageEnum::RESTAURANTE_NAO_ENCONTRADO->value, 404);
    }

    protected function verifyUserHasRole(User $user):void
    {
        dd(!$user->hasRole(RoleEnum::ADMIM_MASTER->value));
        if(!$user->hasRole(RoleEnum::ADMIM_MASTER->value)){
            throw new AuthorizationException(MessageEnum::ACESSO_NEGADO->value, 403);
        }
    }
}