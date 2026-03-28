<?php

namespace App\Policies;

use App\Models\MenuItems;
use App\Models\User;

class MenuItemsPolicy
{
    public function before(User $user)
    {
        if ($user->hasRole('admin_master')) {
            return true;
        }
    }

    public function get(User $user): bool
    {
        return $user->hasRole('admin_master') || $user->hasRole('admin_restaurant');
    }

    public function view(User $user, MenuItems $menuItem): bool
    {
        return $user->restaurants()
            ->where('restaurant.id', $menuItem->menu->restaurant_id)
            ->exists();
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin_master') || $user->hasRole('admin_restaurant');
    }

    public function update(User $user, MenuItems $menuItem): bool
    {
        return $user->restaurants()
            ->where('restaurant.id', $menuItem->menu->restaurant_id)
            ->exists();
    }

    public function delete(User $user, MenuItems $menuItem): bool
    {
        return $user->restaurants()
            ->where('restaurant.id', $menuItem->menu->restaurant_id)
            ->exists();
    }
}
