<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;

Route::get('/cart', [CartController::class, 'index']);
Route::get('/cart/user/{userId}', [CartController::class, 'userCart']);
Route::post('/cart/items', [CartController::class, 'store']);
Route::put('/cart/items/{id}', [CartController::class, 'update']);
Route::delete('/cart/items/{id}', [CartController::class, 'destroy']);
Route::delete('/cart/clear', [CartController::class, 'clear']);

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'service' => 'cart']);
});
