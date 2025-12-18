<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductReviewController;

// Public routes
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/slug/{slug}', [ProductController::class, 'showBySlug']);
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products/category/{categoryId}', [ProductController::class, 'byCategory']);

Route::get('/products/{id}/reviews', [ProductReviewController::class, 'index']);

// Admin routes (временно без auth)
Route::post('/products/{id}/reviews', [ProductReviewController::class, 'store']);
Route::put('/reviews/{id}', [ProductReviewController::class, 'update']);
Route::delete('/reviews/{id}', [ProductReviewController::class, 'destroy']);

Route::post('/categories', [CategoryController::class, 'store']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

Route::post('/products', [ProductController::class, 'store']);
Route::put('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'service' => 'catalog']);
});
