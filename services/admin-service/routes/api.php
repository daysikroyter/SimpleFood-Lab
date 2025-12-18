<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\AnalyticsController;

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::get('/stats', [DashboardController::class, 'stats']);

// User Management
Route::get('/users', [AdminUserController::class, 'index']);
Route::get('/users/{id}', [AdminUserController::class, 'show']);
Route::put('/users/{id}', [AdminUserController::class, 'update']);
Route::delete('/users/{id}', [AdminUserController::class, 'destroy']);

// Product Management
Route::get('/products', [AdminProductController::class, 'index']);
Route::get('/products/{id}', [AdminProductController::class, 'show']);
Route::put('/products/{id}', [AdminProductController::class, 'update']);

// Order Management
Route::get('/orders', [AdminOrderController::class, 'index']);
Route::get('/orders/{id}', [AdminOrderController::class, 'show']);
Route::put('/orders/{id}', [AdminOrderController::class, 'update']);

// Payment Management
Route::get('/payments', [AdminPaymentController::class, 'index']);
Route::get('/payments/{id}', [AdminPaymentController::class, 'show']);

// Settings
Route::get('/settings', [SettingsController::class, 'index']);
Route::put('/settings', [SettingsController::class, 'update']);

// Logs
Route::get('/logs', [LogController::class, 'index']);

// Analytics
Route::get('/analytics', [AnalyticsController::class, 'index']);
Route::get('/analytics/sales', [AnalyticsController::class, 'sales']);
Route::get('/analytics/users', [AnalyticsController::class, 'users']);

Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'service' => 'admin']);
});
