<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\ItemCreateUpdateDelete;
use App\Http\Middleware\OrderCreate;
use App\Http\Middleware\OrderDeliver;
use App\Http\Middleware\OrderPaid;
use App\Http\Middleware\OrderReady;
use App\Http\Middleware\UserCreate;
use Illuminate\Support\Facades\Route;

// login
Route::post('/login', [AuthController::class,'login']);
// login and logout from all device
Route::post('/login-logout-all', [AuthController::class, 'loginLogoutAll']);

// Items
Route::get('/items', [ItemController::class,'index']);
Route::get('/items/{id}', [ItemController::class,'show']);

// with auth:sanctum || wajib login
Route::middleware(['auth:sanctum'])->group(function () {
    // logout
    Route::get('/logout', [AuthController::class,'logout']);
    // logout all
    Route::get('/logout-all', [AuthController::class,'logoutAll']);

    // profile
    Route::get('/profile', [AuthController::class,'profile']);

    // endpoint admin for manage users
    Route::post('/user-create', [UserController::class,'store'])->middleware(UserCreate::class);

    // Item
    Route::post('/items', [ItemController::class,'store'])->middleware(ItemCreateUpdateDelete::class);
    Route::patch('/items/{id}', [ItemController::class,'update'])->middleware(ItemCreateUpdateDelete::class);
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->middleware(ItemCreateUpdateDelete::class);

    // Order
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/order/{id}', [OrderController::class, 'show']);
    Route::get('/orders/ordered', [OrderController::class, 'ordered'])->middleware(OrderReady::class); // buat si chef
    Route::get('/orders/ready', [OrderController::class, 'ready'])->middleware(OrderDeliver::class); // buat si waiter
    Route::get('/orders/delivered', [OrderController::class, 'delivered'])->middleware(OrderPaid::class); // buat si cashier
    Route::post('/order', [OrderController::class,'store'])->middleware(OrderCreate::class); // waiter
    Route::get('/order/{id}/ready', [OrderController::class,'updateReady'])->middleware(OrderReady::class); // chef
    Route::get('/order/{id}/delivered', [OrderController::class,'updateDeliver'])->middleware(OrderDeliver::class); // waiter
    Route::get('/order/{id}/paid', [OrderController::class,'updatePaid'])->middleware(OrderPaid::class); // cashier
});