<?php

namespace App\Policies;

use App\Models\Menu;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class MenuPolicy
{
    public function before(User $user)
    {
        if ($user->hasRole('admin_master')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
         return $user->hasRole('admin_master')
        || $user->hasRole('admin_restaurant');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Menu $menu): bool
    {
        return $user->restaurants()
            ->where('restaurant.id', $menu->restaurant_id)
            ->exists();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Menu $menu): bool
    {
        return $user->restaurants()
            ->where('restaurant.id', $menu->restaurant_id)
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Menu $menu): bool
    {
        return $user->restaurants()
            ->where('restaurant.id', $menu->restaurant_id)
            ->exists();
    }
}
