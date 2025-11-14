<?php

namespace App\Services\Restaurant;

use App\Enums\MessageEnum;
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

    public function get(int $id): Restaurant
    {
        try{
            $user = auth()->user();

            $this->ensureAdminMasterOrRestaurantOwner($user, $id);

            return Restaurant::where('id', $id)->first();
        }catch (\Illuminate\Auth\Access\AuthorizationException $e) {
            throw $e;
        }catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException('Erro ao buscar restaurante', 500);
        }
    }

    public function getAll(): Collection
    {
        try{
            $user = auth()->user();

            $this->verifyUserHasRole($user);

            return Restaurant::where('active', true)->get();
           
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

            return $this->restaurantRepository->update($data);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new SistemException(MessageEnum::RESTAURANTE_NAO_ENCONTRADO->value, 404);
        } catch (\Throwable $e) {
            // dd($e->getMessage());
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
            throw new SistemException(MessageEnum::RESTAURANTE_NAO_ENCONTRADO->value, 404);
        } catch (\Throwable $e) {
            Log::error($e);
            throw new SistemException(MessageEnum::ERRO_AO_DELETAR->value, 500);
        }
    }
}