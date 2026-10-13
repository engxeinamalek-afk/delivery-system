<?php

use App\Http\Controllers\Api\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Api\Admin\OrderDriverController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Api\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Api\Customer\StoreController as CustomerStoreController;
use App\Http\Controllers\Api\Driver\OrderController as DriverOrderController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);  

// الادمن
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {

    // المتاجر
    Route::post('/stores', [AdminStoreController::class, 'store']);
    Route::get('/stores', [AdminStoreController::class, 'index']); 
    Route::patch('/stores/{store}/status', [AdminStoreController::class, 'updateStatus']);

    // Admin routes for orders
    Route::get('/driver/{driver}/orders', [AdminOrderController::class, 'getDriverOrders']);
    Route::get('/orders/delayed', [AdminOrderController::class, 'getDelayedOrders']);
    Route::get('/orders/today', [AdminOrderController::class, 'getTodayOrders']);

    // تغيير السائق
    Route::patch('/orders/{order}/driver',[OrderDriverController::class, 'assignDriver']);


});

// الزبون
Route::middleware(['auth:sanctum', 'role:customer'])->prefix('customer')->group(function(){
    // جلب المتاجر
    Route::get('/stores', [CustomerStoreController::class, 'index']);
    // اضافة اوردر
    Route::post('/orders', [CustomerOrderController::class, 'srore']);

});


// السائق
Route::middleware(['auth:sanctum', 'role:driver'])->prefix('driver')->group(function(){
    Route::get('/orders', [DriverOrderController::class, 'index']);
    Route::patch('/orders/{order}/take', [DriverOrderController::class, 'takeOrder']);
    Route::patch('/orders/{order}/deliver', [DriverOrderController::class, 'deliverOrder']);
});
