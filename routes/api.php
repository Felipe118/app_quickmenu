<?php

use App\Http\Controllers\Auth\AuthController;
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
])->name('register')->middleware('prevent.admin.assignment');

Route::post('/login', [AuthController::class,'login'])->name('login');

Route::get('/teste', function () {
    return response()->json([
        'message' => 'Hello, World! voce tem acesso!',
    ]);
})->middleware('auth:sanctum');

Route::post('/logout', [AuthController::class,'logout'])->name('logout')->middleware('auth:sanctum');
