<?php

namespace App\Services\Restaurant;

use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Models\Restaurant;
use App\Models\User;
use App\Services\BaseService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Pagination\LengthAwarePaginator;

class RestaurantService extends BaseService implements RestaurantServiceInterface
{

    public function __construct(
        private RestaurantRepositoryInterface $restaurantRepository
    ){}

    public function store(array $data): Restaurant
    {
        $userId = auth()->user()->id;
            
        return $this->restaurantRepository->store($userId,$data);
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
        }
    }

    public function index(User $user): LengthAwarePaginator
    {
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
                'active',
                'slug'
            )
            ->where('active', true)
            ->paginate(10);
    } 

    public function update(array $data, Restaurant $restaurant): Restaurant
    {
        return $this->restaurantRepository->update($data, $restaurant);
    }

    public function destroy(Restaurant $restaurant): void
    {
        $restaurant->update(['active' => false]);
    }
}