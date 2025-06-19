<?php

namespace App\Services\Restaurant;

use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Models\Restaurant;

class RestaurantService implements RestaurantServiceInterface
{

    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository
    ){}

    public function storeRestaurant(array $data): Restaurant
    {
        return $this->restaurantRepository->store($data);
    }

    
}