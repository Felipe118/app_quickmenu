<?php

namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;

interface RestaurantServiceInterface
{
    public function storeRestaurant(array $data) :Restaurant;
    public function getRestaurant() :Restaurant;
    public function update(array $data) : Restaurant;
}