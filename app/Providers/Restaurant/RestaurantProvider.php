<?php

namespace App\Providers\Restaurant;

use App\Interfaces\Restaurant\RestaurantRepositoryInterface;
use App\Interfaces\Restaurant\RestaurantServiceInterface;
use App\Repositories\Restaurant\RestaurantRepository;
use App\Services\Restaurant\RestaurantService;
use Illuminate\Support\ServiceProvider;

class RestaurantProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            RestaurantServiceInterface::class,
            RestaurantService::class
        );

        $this->app->bind(
            RestaurantRepositoryInterface::class,
            RestaurantRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
