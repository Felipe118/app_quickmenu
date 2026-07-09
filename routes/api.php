<?php

use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Categories\CategoryController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\MenuItem\MenuItemController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello, World!',
    ]);
});

Route::get('/cardapio/{slug}', [MenuController::class, 'show'])->name('cardapio.show');

Route::post('/register', [
    RegisterController::class,
    'register'
])->name('register');

Route::post('/login', [AuthController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, 'me'])->name('me');
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');

    Route::prefix('addresses')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        RoUTE::post('/', [AddressController::class, 'store'])
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);

        Route::get('/', [AddressController::class, 'index'])
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);

        Route::get('/{address}', [AddressController::class, 'show'])
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);

        Route::put('/{address}', [AddressController::class, 'update'])
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);


        Route::delete('/{address}', [AddressController::class, 'delete'])
            ->middleware(['role:admin_master', 'check.restaurant']);
    });
     
    Route::prefix('restaurants')
    ->middleware(['auth:sanctum'])
    ->group(function () {

        Route::get('/', [RestaurantController::class, 'index'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);

        Route::post('/', [RestaurantController::class, 'store'])
            ->middleware('role:admin_master|admin_restaurant');

        Route::get('/{restaurant}', [RestaurantController::class, 'show'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant','check.restaurant']);

        Route::put('/{restaurant}', [RestaurantController::class, 'update'])
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);

        Route::delete('/{restaurant}', [RestaurantController::class, 'destroy'])
            ->middleware(['role:admin_master','check.restaurant']);

        // Nested resource: categories do restaurante
        Route::get('/{restaurant}/categories', [CategoryController::class, 'index'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);
    });
    
    Route::prefix('menus')->group(function () {
        Route::get('/', [MenuController::class, 'index'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);

        Route::post('/', [MenuController::class, 'store'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant']);

        Route::get('/{menu}', [MenuController::class, 'show'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);

        Route::put('/{menu}', [MenuController::class, 'update'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);

        Route::patch('/{menu}', [MenuController::class, 'destroWy'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);

        Route::delete('/{menu}', [MenuController::class, 'delete'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);
    });

    Route::prefix('categories')
    ->middleware(['auth:sanctum'])
    ->group(function () {
        Route::post('/', [CategoryController::class, 'store'])
            ->middleware(['role:admin_master|admin_restaurant']);

        Route::get('/{categories}', [CategoryController::class, 'show'])
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);
            
        Route::put('/{categories}', [CategoryController::class, 'update'])
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);

        Route::patch('/{categories}', [CategoryController::class, 'destroy'])
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);

        Route::delete('/{categories}', [CategoryController::class, 'delete'])
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);
    });

    Route::prefix('menu-items')->group(function () {
        Route::get('/restaurant/{restaurant}', [MenuItemController::class, 'index'])
            ->name('menuItemsIndex')
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);

        Route::post('/', [MenuItemController::class, 'store'])
            ->name('storeMenuItem')
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant']);

        Route::get('/{menuItem}', [MenuItemController::class, 'show'])
            ->name('showMenuItem')
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);

        Route::put('/{menuItem}', [MenuItemController::class, 'update'])
            ->name('updateMenuItem')
            ->middleware(['role:admin_master|admin_restaurant|user_restaurant', 'check.restaurant']);

        Route::patch('/{menuItem}', [MenuItemController::class, 'destroy'])
            ->name('destroyMenuItem')
            ->middleware(['role:admin_master|admin_restaurant', 'check.restaurant']);

        Route::delete('/{menuItem}', [MenuItemController::class, 'delete'])
            ->name('deleteMenuItem')
            ->middleware(['role:admin_master', 'check.restaurant']);
    });
});