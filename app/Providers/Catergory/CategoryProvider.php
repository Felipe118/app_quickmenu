<?php

namespace App\Providers\Catergory;

use App\Interfaces\Categories\CategoryServiceInterface;
use App\Services\Categories\CategoryService;
use Illuminate\Support\ServiceProvider;

class CategoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryServiceInterface::class,
            CategoryService::class
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
