<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\StoreController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);  

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    Route::post('/stores', [StoreController::class, 'store']);
    Route::patch('/stores/{store}/status', [StoreController::class, 'updateStatus']);
});
