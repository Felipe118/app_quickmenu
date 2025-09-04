<?php

namespace App\Interfaces\Restaurant;

use App\Exceptions\Address\SistemException;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;

interface RestaurantServiceInterface
{
    public function storeRestaurant(array $data) :Restaurant;
    public function getRestaurant() :Collection;
    public function update(array $data) : Restaurant;
    public function destroyRestaurant(int $id) : Restaurant|SistemException;
}