<?php

namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;

interface RestaurantServiceInterface
{
    public function storeRestaurant(array $data) :Restaurant;
}