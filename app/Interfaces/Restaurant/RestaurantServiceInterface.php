<?php

namespace App\Interfaces\Restaurant;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

interface RestaurantServiceInterface
{
    public function store(array $data): Restaurant;
    public function getRestaurant(Restaurant $restaurant, User $user): Restaurant;
    public function index(User $user): LengthAwarePaginator;
    public function update(array $data, Restaurant $restaurant): void;
    public function destroy(Restaurant $restaurant): void;
}