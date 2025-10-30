<?php

namespace App\Validation;

use App\Enums\RoleEnum;
use App\Exceptions\SistemException;

class UserValidation
{
    public function validateIfUserIsOwnerRestaurantOrMaster($user): void
    {
          $userRes = $user->restaurants()->where('user_id', $user->id)->get();

          if(
               !$user->hasRole(RoleEnum::ADMIM_MASTER->value) && 
               !$userRes->isEmpty() 
          ){
               throw new SistemException('Você nao tem permissao para executar essa ação',403);
          }
    }
}