<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;

// Users
Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [UserController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [UserController::class, 'fetch']);
    Route::patch('/user', [UserController::class, 'update']);
    Route::delete('/logout', [UserController::class, 'logout']);
});

// Products
Route::get('/products', [ProductController::class, 'all']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Categories
Route::get('/categories', [ProductCategoryController::class, 'all']);
Route::get('/categories/{id}', [ProductCategoryController::class, 'show']);
