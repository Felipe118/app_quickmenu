<?php

namespace App\Services\Restaurant;

use App\Exceptions\Address\SistemException;
use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Models\Restaurant;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RestaurantService implements RestaurantServiceInterface
{

    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository
    ){}

    public function storeRestaurant(array $data): Restaurant
    {
        try{
            //$idUser = Auth::user()->id;

            $restaunt = $this->restaurantRepository->store($data);

            //$restaunt->users()->syncWithoutDetaching($idUser);

            return $restaunt;
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar restaurante');
        }
       
    }

    public function getRestaurantById(int $id): Restaurant
    {
        $user = auth()->user();

        $restaurant = $user->restaurants()->where('restaurants.id', $id)->first();

        if(!$restaurant){
            throw new SistemException('Restaurante nao encontrado.', 404);
        }
        
        return $restaurant; 
    }

    public function update(int $id, array $data): Restaurant
    {
        try{
            return $this->restaurantRepository->update($id, $data);
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao atualizar restaurante');
        }
    }
}