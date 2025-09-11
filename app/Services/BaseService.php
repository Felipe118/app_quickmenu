<?php 

namespace App\Services;

use App\Enums\RoleEnum;
use Illuminate\Auth\Access\AuthorizationException;

abstract class BaseService
{
    protected function ensureAdminMasterOrRestaurantOwner($user, $id) :void
    {
        if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
            return;
        }
        
        if($user->restaurants()->where('restaurant_id', $id)->exists()){
           return;
        }

        throw new AuthorizationException('Acesso negado', 403);
    }   
}