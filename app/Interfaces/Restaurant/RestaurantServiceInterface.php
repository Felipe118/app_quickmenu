<?php

namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

interface RestaurantServiceInterface
{
    public function storeRestaurant(array $data) :Restaurant;
    public function get(int $id) :Restaurant;
    public function index(User $user) :Collection;
    public function update(array $data) :Restaurant;
    public function destroyRestaurant(int $id) : void;
}