<?php

namespace App\Repositories\Restaurant;

use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Models\Restaurant;

class RestaurantRepository implements RestaurantRepositoryInterface
{
    public function __construct(
        public Restaurant $restaurant
    )
    {}
    public function store(array $data) :Restaurant
    {
        $restaurant = $this->restaurant->create(
          [
            'name' => $data['name'],
            'email' => $data['email'],
            'perfil_img' => $data['perfil_img'],
            'capa_img' => $data['capa_img'],
            'open_time' => $data['open_time'],
            'close_time' => $data['close_time'],
            'phone' => $data['phone'],
            'active'=> true,
            'address_id' => $data['address_id']
          ]
        );

        return $restaurant;
    }
}