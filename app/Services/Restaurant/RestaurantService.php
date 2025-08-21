<?php

namespace App\Services\Restaurant;

use App\Enums\RoleEnum;
use App\Exceptions\Address\SistemException;
use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Models\Restaurant;
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

    public function getRestaurant(): Restaurant
    {
       
        try{
            $user = auth()->user();

            if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
                return Restaurant::where('active', true)->get();
            }

            return $user->restaurants()->where('user_id', $user->id)->get();
   
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

}