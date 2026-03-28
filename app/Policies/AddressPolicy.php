<?php

namespace App\Policies;

use App\Models\Address;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AddressPolicy
{
    public function before(User $user)
    {
        if ($user->hasRole('admin_master')) {
            return true;
        }
    }

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin_master') || $user->hasRole('admin_restaurant');
    }

    public function view(User $user, Address $address): bool
    {
        $restaurant = Restaurant::where('address_id', $address->id)->first();

        if (!$restaurant) {
            return false;
        }
      
        return $user->restaurants()
            ->where('restaurant.id', $restaurant->id)
            ->exists();
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin_master') || $user->hasRole('admin_restaurant');
    }

    public function update(User $user, Address $address): bool
    {
        $restaurant = Restaurant::where('address_id', $address->id)->first();

        if (!$restaurant) {
            return false;
        }
      
        return $user->restaurants()
            ->where('restaurant.id', $restaurant->id)
            ->exists();
    }

    public function delete(User $user, Address $address): bool
    {
        $restaurant = Restaurant::where('address_id', $address->id)->first();

        if (!$restaurant) {
            return false;
        }

        return $user->restaurants()
            ->where('restaurant.id', $restaurant->id)
            ->exists();
    }
}
