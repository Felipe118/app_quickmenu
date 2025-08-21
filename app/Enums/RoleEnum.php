<?php

namespace App\Enums;

enum RoleEnum :string
{
    case ADMIM_MASTER = 'admin_master';
    case ADMIN_RESTAURANT = 'admin_restaurant';
    case USER_RESTAURANT = 'user_restaurant';
    case USER = 'user';

}
