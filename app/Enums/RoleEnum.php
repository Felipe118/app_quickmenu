<?php

namespace App\Enums;

enum RoleEnum :string
{
    case ADMIM_MASTER = 'admin_master';
    case ADMIN_RESTAURANT = 'admin_restaurant';
    case USER_RESTAURANT = 'user_restaurant';
    case USER = 'user';

    public function getId(): int
    {
        return match($this) {
            self::ADMIM_MASTER => 1,
            self::ADMIN_RESTAURANT => 2,
            self::USER_RESTAURANT => 3,
            self::USER => 4,
        };
    }

    public static function fromId(int $id): ?self
    {
        return match($id) {
            1 => self::ADMIM_MASTER,
            2 => self::ADMIN_RESTAURANT,
            3 => self::USER_RESTAURANT,
            4 => self::USER,
            default => null,
        };
    }
}
