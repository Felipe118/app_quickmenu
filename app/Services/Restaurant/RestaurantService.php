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
    try {
        $user = auth()->user();

        $restaurant = Restaurant::with('users')->findOrFail($data['id']);

        if (
            $restaurant->users()->where('user_id', $user->id)->exists() &&
            $restaurant->users()->where('restaurant_id', $data['id'])->exists() &&
            $user->hasRole(RoleEnum::ADMIN_RESTAURANT->value)
        ) {
            return $this->restaurantRepository->update($data);
        }

        // Caso seja admin master
        if ($user->hasRole(RoleEnum::ADMIM_MASTER->value)) {
            return $this->restaurantRepository->update($data);
        }

        throw new SistemException('Acesso negado', 403);

    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        throw new SistemException('Restaurante não encontrado', 404);
    } catch (\Throwable $e) {
        Log::error($e->getMessage());
        throw new SistemException($e->getMessage(),$e->getCode());
    }
}


    // private function verifyRestaurant(int $id): Restaurant
    // {
    //     $user = auth()->user();

    //     $restaurant = $user->restaurant();

    //     if($restaurant->id == $id)
    // }

    public function destroyRestaurant(int $id): Restaurant
    {
        try{
            $restaunt = Restaurant::find($id);

            if(!$restaunt){
                throw new SistemException('Restaurante nao encontrado',404);
            }
            
            $restaunt->update(['active' => false, 'deleted_at' => now()])->save();

            return $restaunt;
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao deletar restaurante');
        }
    }

}