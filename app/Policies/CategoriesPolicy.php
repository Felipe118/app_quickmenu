<?php

namespace App\Policies;

use App\Models\Categories;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CategoriesPolicy
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
    public function get(User $user): bool
    {
        return $user->hasRole('admin_master')
        || $user->hasRole('admin_restaurant');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Categories $categories): bool
    {
        return $user->restaurants()
            ->where('restaurant.id', $categories->restaurant_id)
            ->exists();
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Categories $categories): bool
    {
       return $user->restaurants()
            ->where('restaurant.id', $categories->restaurant_id)
            ->exists();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Categories $categories): bool
    {
         return $user->restaurants()
            ->where('restaurant.id', $categories->restaurant_id)
            ->exists();
    }
}
