<?php

namespace App\Providers\Address;

use App\Interfaces\Address\AddressRepositoryInterface;
use App\Interfaces\Address\AddressServiceInterface;
use App\Repositories\Address\AddressRepository;
use App\Services\Address\AddressService;
use Illuminate\Support\ServiceProvider;

class AddressProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AddressServiceInterface::class,
            AddressService::class
        );

        $this->app->bind(
            AddressRepositoryInterface::class,
            AddressRepository::class
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
