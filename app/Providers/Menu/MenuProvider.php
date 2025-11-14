<?php

namespace App\Providers\Menu;

use App\Interfaces\Menu\MenuServiceInterface;
use App\Services\Menu\MenuService;
use Illuminate\Support\ServiceProvider;

class MenuProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            MenuServiceInterface::class,
            MenuService::class
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
