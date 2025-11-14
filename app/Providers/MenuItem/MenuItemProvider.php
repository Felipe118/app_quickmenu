<?php

namespace App\Providers\MenuItem;

use App\Interfaces\MenuItem\MenuItemServiceInterface;
use App\Services\MenuItem\MenuItemService;
use Illuminate\Support\ServiceProvider;

class MenuItemProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
         $this->app->bind(
            MenuItemServiceInterface::class,
            MenuItemService::class
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
