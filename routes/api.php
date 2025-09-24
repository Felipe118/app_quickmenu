<?php

use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Menu\MenuController;
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

    Route::group(['prefix' => 'restaurant'], function () {
        Route::post('/store', [RestaurantController::class, 'store'])
            ->name('storeRestaurant')
            ->middleware('role:admin_master|admin_restaurant');
        Route::post('/update', [RestaurantController::class, 'update'])
            ->name('updateRestaurant')
            ->middleware('role:admin_master|admin_restaurant');
        Route::get('/get', [RestaurantController::class, 'get'])
            ->name('getRestaurant')
            ->middleware('role:admin_master|admin_restaurant|user_restaurant');
        Route::delete('/delete/{id}', [RestaurantController::class, 'destroy'])
            ->name('destroy')
            ->middleware('role:admin_master');
    });

    Route::group(['prefix'=> 'menu'], function () {
        Route::post('/store', [MenuController::class,'store'])
            ->name('storeMenu')
            ->middleware('role:admin_master|admin_restaurant|user_restaurant');

        Route::post('/update', [MenuController::class,'update'])
            ->name('updateMenu')
            ->middleware('role:admin_master|admin_restaurant|user_restaurant');

        Route::get('/get/{restaurant_id}/{id?}', [MenuController::class,'get'])
            ->name('getMenu')
            ->middleware('role:admin_master|admin_restaurant|user_restaurant');

        Route::put('/destroy/{restaurant_id}/{id}', [MenuController::class,'destroy'])
            ->name('destroyMenu')
            ->middleware('role:admin_master');

        Route::delete('/delete/{restaurant_id}/{id}', [MenuController::class,'delete'])
            ->name('deleteMenu')
            ->middleware('role:admin_master');
            
    });

});