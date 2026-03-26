<?php

namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface RestaurantServiceInterface
{
    public function storeRestaurant(array $data) :Restaurant;
    public function get(Restaurant $restaurant, User $user) : Restaurant;
    public function index(User $user) :Collection;
    public function update(array $data, Restaurant $restaurant) :Restaurant;
    public function destroyRestaurant(Restaurant $restaurant) : void;
}