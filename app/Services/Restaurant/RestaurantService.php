<?php

namespace App\Services\Restaurant;

use App\Enums\RoleEnum;
use App\Exceptions\SistemException;
use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Models\Restaurant;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class RestaurantService extends BaseService implements RestaurantServiceInterface
{

    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository
    ){}

    public function storeRestaurant(array $data): Restaurant
    {
        try{
            $userId = auth()->user()->id;
            
            return $this->restaurantRepository->store($userId,$data);
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar restaurante');
        }
       
    }

    public function get(int $id): Collection
    {
        try{
            $user = auth()->user();

            if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
                return Restaurant::where('id', $id)
                ->where('active', true)
                ->get();
            }
            
            return $user->restaurants()->where('user_id', $user->id)
                 ->where('restaurant_id', $id)
                 ->get();
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Restaurante nao encontrado',404);
        } 
    }

    public function getAll(): Collection
    {
        try{
            $user = auth()->user();

            if($user->hasRole(RoleEnum::ADMIM_MASTER->value)){
                return Restaurant::where('active', true)
                ->all();
            }

            return $user->restaurants()->where('user_id', $user->id)->get();
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Restaurante nao encontrado',404);
        }
    }

    public function update(array $data): Restaurant
    {
        try {
            $user = auth()->user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $data['id']);

            return Restaurant::with('users')->findOrFail($data['id']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new SistemException('Restaurante não encontrado', 404);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode());
        }
    }


    public function destroyRestaurant(int $id): void
    {
        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->update(['active' => false]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new SistemException('Restaurante não encontrado', 404);
        } catch (\Throwable $e) {
            Log::error($e);
            throw new SistemException('Erro ao desativar restaurante', 500);
        }
    }


}