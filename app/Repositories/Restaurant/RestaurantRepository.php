<?php

namespace App\Repositories\Restaurant;

use App\Helpers\SlugHelpers;
use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Models\Restaurant;

class RestaurantRepository implements RestaurantRepositoryInterface
{
    public function __construct(
        private Restaurant $restaurant,
        private SlugHelpers $slugHelpers
    )
    {}
    public function store(int $userId,array $data) :Restaurant
    {
        $slug = $this->slugHelpers->slugify($data["name"]);

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
              'address_id' => $data['address_id'],
              'slug' => $slug
          ]
        );

        $restaurant->users()->syncWithoutDetaching($userId);

        return $restaurant;
    }

    public function update(array $data) :Restaurant
    {
      $restaurant = $this->restaurant->findOrFail($data['id']);

      $restaurant->update([
          'name'=> $data['name'] ?? $restaurant->name,
          'email'=> $data['email'] ?? $restaurant->email,
          'perfil_img' => $data['perfil_img'] ?? $restaurant->perfil_img,
          'capa_img' => $data['capa_img']  ?? $restaurant->capa_img,
          'open_time' => $data['open_time'] ?? $restaurant->open_time,
          'close_time' => $data['close_time'] ?? $restaurant->close_time,
          'phone' => $data['phone'] ?? $restaurant->phone, 
          'active' => true,
          'address_id' => $data['address_id'] ?? $restaurant->address_id,
          'slug' => $this->slugHelpers->slugify($data['name'])
      ]);
      
      return $restaurant;
    }
}