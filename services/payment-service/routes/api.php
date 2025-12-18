<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RefundController;

// Payments
Route::get('/payments', [PaymentController::class, 'index']);
Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments/{id}', [PaymentController::class, 'show']);
    Route::post('/payments/{id}/confirm', [PaymentController::class, 'confirm']);
    Route::post('/payments/{id}/cancel', [PaymentController::class, 'cancel']);
    
    // Transactions
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/transactions/{id}', [TransactionController::class, 'show']);
    
    // Refunds
    Route::post('/refunds', [RefundController::class, 'store']);
    Route::get('/refunds/{id}', [RefundController::class, 'show']);
    
// Admin only
Route::post('/refunds/{id}/approve', [RefundController::class, 'approve']);
Route::post('/refunds/{id}/reject', [RefundController::class, 'reject']);

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'service' => 'payment']);
});
