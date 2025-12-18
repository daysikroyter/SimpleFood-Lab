<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'service' => 'api-gateway',
        'timestamp' => now()->toIso8601String()
    ]);
});

// Proxy routes to microservices
Route::prefix('api')->group(function () {
    // Auth Service
    Route::any('/auth/{any}', function (Request $request) {
        return app('gateway')->forward('auth-service', $request);
    })->where('any', '.*');
    
    // Catalog Service
    Route::any('/catalog/{any}', function (Request $request) {
        return app('gateway')->forward('catalog-service', $request);
    })->where('any', '.*');
    
    Route::any('/products/{any}', function (Request $request) {
        return app('gateway')->forward('catalog-service', $request);
    })->where('any', '.*');
    
    Route::any('/categories/{any}', function (Request $request) {
        return app('gateway')->forward('catalog-service', $request);
    })->where('any', '.*');
    
    // Cart Service
    Route::any('/cart/{any}', function (Request $request) {
        return app('gateway')->forward('cart-service', $request);
    })->where('any', '.*');
    
    // Order Service
    Route::any('/orders/{any}', function (Request $request) {
        return app('gateway')->forward('order-service', $request);
    })->where('any', '.*');
    
    // Payment Service
    Route::any('/payments/{any}', function (Request $request) {
        return app('gateway')->forward('payment-service', $request);
    })->where('any', '.*');
    
    Route::any('/transactions/{any}', function (Request $request) {
        return app('gateway')->forward('payment-service', $request);
    })->where('any', '.*');
    
    Route::any('/refunds/{any}', function (Request $request) {
        return app('gateway')->forward('payment-service', $request);
    })->where('any', '.*');
    
    // Admin Service
    Route::any('/admin/{any}', function (Request $request) {
        return app('gateway')->forward('admin-service', $request);
    })->where('any', '.*');
});
