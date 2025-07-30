<?php

namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;

interface RestaurantServiceInterface
{
    public function storeRestaurant(array $data) :Restaurant;
    public function getRestaurantById(int $id) :Restaurant;
    public function getRestaurantByuser() :Collection;
    public function getRestaurants() :Collection;
    public function update(array $data) :Restaurant;
}