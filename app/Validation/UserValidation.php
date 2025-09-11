<?php

namespace App\Validation;

use App\Enums\RoleEnum;
use App\Exceptions\Address\SistemException;

class UserValidation
{
    public static function validateIfUserIsOwnerRestaurantOrMaster($user) :bool
    {
       if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
            return true;
       }

       $userRes = $user->restaurants()->where('user_id', $user->id)->get();

       if($userRes->isEmpty()){
            return false;
       }

       return true;
    }
}