<?php

namespace App\Providers\Register;

use App\Interfaces\User\RegisterRepositoryInterface;
use App\Interfaces\User\RegisterServiceInterface;
use App\Repositories\User\RegisterRepository;
use App\Services\User\RegisterService;
use Illuminate\Support\ServiceProvider;

class RegisterProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            RegisterServiceInterface::class,
        RegisterService::class
        );
        $this->app->bind(
            RegisterRepositoryInterface::class,
            RegisterRepository::class
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
