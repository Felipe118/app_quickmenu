<?php

use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Restaurant\RestaurantController;
use App\Http\Controllers\User\RegisterController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello, World!',
    ]);
});


Route::post('/register', [
    RegisterController::class,
    'register'
])->name('register');

Route::post('/login', [AuthController::class,'login'])->name('login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');

    Route::group(['prefix' => 'address'], function () {
        Route::post('/store', [AddressController::class,'storeAddress'])->name('storeAddress');
        Route::put('/update/{id}', [AddressController::class, 'updateAddress'])->name('updateAddress');
        Route::get('get/{id}', [AddressController::class, 'getAddress'])->name('getAddressById');
        Route::delete('/delete/{id}', [AddressController::class, 'destroyAddress'])->name('destroyAddress');
    });

    Route::group(['prefix' => 'restaurant'], function () {
        Route::post('/store', [RestaurantController::class, 'storeRestaurant'])
            ->name('storeRestaurant')
            ->middleware('permission:restaurants-create');
        Route::post('/update', [RestaurantController::class, 'updateRestaurant'])
            ->name('updateRestaurant')
            ->middleware('permission:restaurants-edit');
        Route::get('/get', [RestaurantController::class, 'getRestautant'])
            ->name('getRestautant')
            ->middleware('permission:restaurants-list');
        Route::delete('/delete/{id}', [RestaurantController::class, 'destroyRestaurant']);
        Route::post('disable', [RestaurantController::class,'disable'])
            ->name('disable');
    });
});