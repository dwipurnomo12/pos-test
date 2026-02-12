<?php

use App\Http\Controllers\API\CustomerController;
use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/customers', [CustomerController::class, 'index']);

Route::get('/categories', [ProductController::class, 'categories']);
Route::get('/suppliers', [ProductController::class, 'supplier']);
Route::get('/products', [ProductController::class, 'products']);
Route::get('/product/{id}', [ProductController::class, 'show']);
Route::post('/product', [ProductController::class, 'storeProduct']);
