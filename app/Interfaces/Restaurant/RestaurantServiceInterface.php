<?php

namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;

interface RestaurantServiceInterface
{
    public function storeRestaurant(array $data) :Restaurant;
    public function getRestaurantById(int $id) :Restaurant;
    public function update(int $id, array $data) :Restaurant;
}