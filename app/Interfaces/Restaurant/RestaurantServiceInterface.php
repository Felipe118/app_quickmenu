<?php

namespace App\Interfaces\Restaurant;

use App\Exceptions\SistemException;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;

interface RestaurantServiceInterface
{
    public function storeRestaurant(array $data) :Restaurant;
    public function get(int $id) :Collection;
    public function getAll() :Collection;
    public function update(array $data) : Restaurant;
    public function destroyRestaurant(int $id) : Restaurant|SistemException;
}