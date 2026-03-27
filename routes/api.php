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

    Route::group(['prefix' => 'address'], function () {
        Route::post('/store', [AddressController::class,'storeAddress'])
            ->name('storeAddress')
            ->middleware('role:admin_master|admin_restaurant');
        Route::put('/update/{id}', [AddressController::class, 'updateAddress'])
            ->name('updateAddress')
            ->middleware('role:admin_master|admin_restaurant');
        Route::get('get/{id}', [AddressController::class, 'getAddress'])
            ->name('getAddressById')
            ->middleware('role:admin_master|admin_restaurant');
        Route::delete('/delete/{id}', [AddressController::class, 'destroyAddress'])
            ->name('destroyAddress')
            ->middleware('role:admin_master|admin_restaurant');
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
        Route::get('/', [MenuController::class, 'index']);
        Route::post('/', [MenuController::class, 'store']);
        Route::get('/{menu}', [MenuController::class, 'show']);
        Route::put('/{menu}', [MenuController::class, 'update']);
        Route::patch('/{menu}', [MenuController::class, 'destroy']);
        Route::delete('/{menu}', [MenuController::class, 'delete']);

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

    Route::group(['prefix'=> 'menu-item'], function () {
        Route::post('/store', [MenuItemController::class,'store'])
            ->name('storeMenuItem')
            ->middleware('role:admin_master|admin_restaurant|user_restaurant');

        Route::put('/update', [MenuItemController::class,'update'])
            ->name('updateMenuItem')
            ->middleware('role:admin_master|admin_restaurant|user_restaurant');

        Route::get('/get/{id}/restaurant/{restaurant_id}', [MenuItemController::class,'get'])
            ->name('getMenuItem')
            ->middleware('role:admin_master|admin_restaurant|user_restaurant');
        
        Route::get('/getAll/restaurant/{restaurant_id}', [MenuItemController::class,'getAll'])
            ->name('getAllMenuItem')
            ->middleware('role:admin_master|admin_restaurant|user_restaurant');

        Route::patch('/destroy/{id}/restaurant/{restaurant_id}', [MenuItemController::class,'destroy'])
            ->name('destroyMenuItem')
            ->middleware('role:admin_master|admin_restaurant');

        Route::delete('/delete/{id}/restaurant/{restaurant_id}', [MenuItemController::class,'delete'])
            ->name('deleteMenuItem')
            ->middleware('role:admin_master');
    });


});