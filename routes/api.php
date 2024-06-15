<?php

use App\Http\Controllers\Api\ProductCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'all']);
Route::get('/products/{id}', [ProductController::class, 'show']);

Route::get('/categories', [ProductCategoryController::class, 'all']);
Route::get('/categories/{id}', [ProductCategoryController::class, 'show']);
