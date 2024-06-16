<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\ProductCategoryController;

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'fetch']);
    Route::patch('/user', [UserController::class, 'update']);
    Route::delete('/logout', [UserController::class, 'logout']);

    Route::get('/transactions', [TransactionController::class, 'all']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
});

Route::get('/products', [ProductController::class, 'all']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [ProductCategoryController::class, 'all']);
Route::get('/categories/{id}', [ProductCategoryController::class, 'show']);
