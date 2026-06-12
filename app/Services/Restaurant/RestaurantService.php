<?php

namespace App\Services\Restaurant;

use App\Enums\MessageEnum;
use App\Exceptions\SistemException;
use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class RestaurantService extends BaseService implements RestaurantServiceInterface
{

    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository
    ){}

    public function store(array $data): Restaurant
    {
        try{
            $userId = auth()->user()->id;
            
            return $this->restaurantRepository->store($userId,$data);
        }catch(\Throwable $e){
            Log::error($e->getMessage());
            throw new SistemException('Erro ao salvar restaurante');
        }
    }

    public function getRestaurant(Restaurant $restaurant, User $user): Restaurant
    {
        try{
            return Restaurant::visibleTo($user)
                ->select(
                    'id',
                    'name',
                    'perfil_img',	
                    'capa_img',
                    'open_time',
                    'close_time',	
                    'phone',
                    'email',
                    'address_id',	
                    'slug'
                )
                ->where('active', true)
                ->where('id', $restaurant->id)
                ->first();
        }catch (AuthorizationException $e) {
            throw $e;
        }catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException('Erro ao buscar restaurante', 500);
        }
    }

    public function index(User $user): Collection
    {
        try {
            return Restaurant::visibleTo($user)
                ->where('active', true)
                ->get();
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage());
        }
    } 

    public function update(array $data, Restaurant $restaurant): Restaurant
    {
        try {
            return $this->restaurantRepository->update($data, $restaurant);
        } catch (ModelNotFoundException $e) {
            throw new SistemException(MessageEnum::RESTAURANTE_NAO_ENCONTRADO->value, 404);
        } catch (\Throwable $e) {
            Log::error($e->getMessage());
            throw new SistemException($e->getMessage(),$e->getCode());
        }
    }


    public function destroy(Restaurant $restaurant): void
    {
        try {
            $restaurant->update(['active' => false]);
        } catch (ModelNotFoundException $e) {
            throw new SistemException(MessageEnum::RESTAURANTE_NAO_ENCONTRADO->value, 404);
        } catch (\Throwable $e) {
            Log::error($e);
            throw new SistemException(MessageEnum::ERRO_AO_DELETAR->value, 500);
        }
    }
}