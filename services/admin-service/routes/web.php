<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    // Получаем данные из API dashboard
    try {
        $dashboardData = app(\App\Http\Controllers\Api\DashboardController::class)->index();
        $data = json_decode($dashboardData->getContent(), true);
        
        $stats = [
            'users' => $data['data']['stats']['total_users'] ?? 0,
            'products' => $data['data']['stats']['total_products'] ?? 0,
            'orders' => $data['data']['stats']['total_orders'] ?? 0,
            'revenue' => $data['data']['stats']['total_revenue'] ?? 0,
        ];
        
        $recentOrders = array_map(function($order) {
            return [
                'id' => $order['id'] ?? 'N/A',
                'customer' => $order['user']['name'] ?? 'Гость',
                'total' => number_format($order['total_amount'] ?? 0, 0, ',', ' '),
                'status' => $order['status'] ?? 'pending',
            ];
        }, $data['data']['recent_orders'] ?? []);
    } catch (\Exception $e) {
        // Используем демо-данные если API недоступен
        $stats = [
            'users' => 150,
            'products' => 45,
            'orders' => 320,
            'revenue' => 156000,
        ];
        $recentOrders = [];
    }
    
    return view('dashboard', compact('stats', 'recentOrders'));
});

Route::get('/api-info', function () {
    return response()->json([
        'service' => 'Admin Service',
        'status' => 'running',
        'version' => '1.0.0'
    ]);
});

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
