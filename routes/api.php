<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ProductCategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Products
Route::get('/products', [ProductController::class, 'all']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Categories
Route::get('/categories', [ProductCategoryController::class, 'all']);
Route::get('/categories/{id}', [ProductCategoryController::class, 'show']);

// Users
Route::post('/register', [UserController::class, 'register']);
