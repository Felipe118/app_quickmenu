<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\RegisterController;
use App\Http\Middleware\PreventAdminAssignmentMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'message' => 'Hello, World!',
    ]);
});

Route::post('/register', [
    RegisterController::class,
    'register'
])->name('register')->middleware(PreventAdminAssignmentMiddleware::class);

Route::post('/login', [AuthController::class,'login'])->name('login');


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class,'logout'])->name('logout');
});