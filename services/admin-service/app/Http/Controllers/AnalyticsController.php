<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AnalyticsController extends Controller
{
    private $orderServiceUrl = 'http://localhost:8000';
    private $authServiceUrl = 'http://localhost:8001';
    private $catalogServiceUrl = 'http://localhost:8002';

    public function index()
    {
        return response()->json([
            'sales' => $this->getSalesData(),
            'users' => $this->getUsersData(),
            'products' => $this->getProductsData(),
        ]);
    }

    public function sales(Request $request)
    {
        $startDate = $request->input('start_date', now()->subDays(30));
        $endDate = $request->input('end_date', now());

        $response = Http::get("{$this->orderServiceUrl}/api/orders", [
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);

        $orders = $response->json()['data'] ?? [];

        $totalRevenue = collect($orders)->sum('total_amount');
        $totalOrders = count($orders);
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        return response()->json([
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'average_order_value' => $averageOrderValue,
            'orders_by_date' => $this->groupOrdersByDate($orders),
        ]);
    }

    public function users(Request $request)
    {
        $response = Http::get("{$this->authServiceUrl}/api/users");

        $users = $response->json()['data'] ?? [];

        return response()->json([
            'total_users' => count($users),
            'new_users_this_month' => $this->countNewUsers($users),
            'users_by_date' => $this->groupUsersByDate($users),
        ]);
    }

    private function getSalesData()
    {
        $response = Http::get("{$this->orderServiceUrl}/api/orders");
        $orders = $response->json()['data'] ?? [];

        return [
            'total_revenue' => collect($orders)->sum('total_amount'),
            'total_orders' => count($orders),
        ];
    }

    private function getUsersData()
    {
        $response = Http::get("{$this->authServiceUrl}/api/users");
        return ['total_users' => count($response->json()['data'] ?? [])];
    }

    private function getProductsData()
    {
        $response = Http::get("{$this->catalogServiceUrl}/api/products");
        return ['total_products' => count($response->json()['data'] ?? [])];
    }

    private function groupOrdersByDate($orders)
    {
        return collect($orders)
            ->groupBy(fn($order) => date('Y-m-d', strtotime($order['created_at'])))
            ->map(fn($group) => [
                'count' => count($group),
                'revenue' => $group->sum('total_amount'),
            ]);
    }

    private function countNewUsers($users)
    {
        $startOfMonth = now()->startOfMonth();
        return collect($users)
            ->filter(fn($user) => strtotime($user['created_at']) >= $startOfMonth->timestamp)
            ->count();
    }

    private function groupUsersByDate($users)
    {
        return collect($users)
            ->groupBy(fn($user) => date('Y-m-d', strtotime($user['created_at'])))
            ->map(fn($group) => count($group));
    }
}
