<?php

namespace App\Services\Restaurant;

use App\Exceptions\Address\SistemException;
use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class RestaurantService implements RestaurantServiceInterface
{

    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository
    ){}

    public function storeRestaurant(array $data): Restaurant
    {
        try{
            $userId = auth()->user()->id;
            
            $restaunt = $this->restaurantRepository->store($userId,$data);

            return $restaunt;
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar restaurante');
        }
       
    }

    public function getRestaurantById(int $id): Restaurant
    {
       
        try{
            $user = auth()->user();
            
            $restaurant = $user->restaurants()->where('restaurant.id', $id)->first();

            if(!$restaurant){
                throw new SistemException('Restaurante nao encontrado.', 404);
            }

            return $restaurant; 
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao buscar restaurante',500);
        } 
    }

    public function update(array $data): Restaurant
    {
        try{
            return $this->restaurantRepository->update($data);
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao atualizar restaurante');
        }
    }


    public function getRestaurants() :Collection
    {
        try{
            return Restaurant::all();
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao buscar restaurantes');
        }

    }

    public function getRestaurantByuser() :Collection
    {
        try{
            return auth()->user()->restaurants()->get();
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao buscar restaurante');
        }
    }
}