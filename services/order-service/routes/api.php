<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;

Route::get('/orders', [OrderController::class, 'index']);
Route::post('/orders', [OrderController::class, 'store']);
Route::get('/orders/{id}', [OrderController::class, 'show']);
Route::delete('/orders/{id}', [OrderController::class, 'destroy']);
Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus']);

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'service' => 'order']);
});
