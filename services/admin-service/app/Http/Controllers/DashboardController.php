<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Получаем статистику из всех сервисов
        $stats = [
            'users' => $this->getUsersData(),
            'products' => $this->getProductsData(),
            'orders' => $this->getOrdersData(),
            'payments' => $this->getPaymentsData(),
        ];

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }

    public function stats(Request $request)
    {
        $period = $request->get('period', '30days');

        return response()->json([
            'success' => true,
            'data' => [
                'sales' => [],
                'orders' => [],
                'users' => [],
            ],
        ]);
    }

    private function getUsersData()
    {
        try {
            $response = Http::timeout(5)->get('http://simplefood-auth-service/api/users');
            if ($response->successful()) {
                $data = $response->json();
                $count = $data['total'] ?? count($data['data'] ?? []);
                return [
                    'count' => $count,
                    'status' => 'ok',
                ];
            }
            return ['count' => 0, 'status' => 'error', 'message' => 'Service unavailable'];
        } catch (\Exception $e) {
            return ['count' => 0, 'status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function getProductsData()
    {
        try {
            $response = Http::timeout(5)->get('http://simplefood-catalog-service/api/products');
            if ($response->successful()) {
                $data = $response->json();
                $count = $data['total'] ?? count($data['data'] ?? []);
                return [
                    'count' => $count,
                    'status' => 'ok',
                ];
            }
            return ['count' => 0, 'status' => 'error', 'message' => 'Service unavailable'];
        } catch (\Exception $e) {
            return ['count' => 0, 'status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function getOrdersData()
    {
        try {
            $response = Http::timeout(5)->get('http://simplefood-order-service/api/orders');
            if ($response->successful()) {
                $data = $response->json();
                $count = $data['total'] ?? count($data['data'] ?? []);
                return [
                    'count' => $count,
                    'status' => 'ok',
                ];
            }
            return ['count' => 0, 'status' => 'error', 'message' => 'Service unavailable'];
        } catch (\Exception $e) {
            return ['count' => 0, 'status' => 'error', 'message' => $e->getMessage()];
        }
    }

    private function getPaymentsData()
    {
        try {
            $response = Http::timeout(5)->get('http://simplefood-payment-service/api/payments');
            if ($response->successful()) {
                $data = $response->json();
                $count = $data['total'] ?? count($data['data'] ?? []);
                return [
                    'count' => $count,
                    'status' => 'ok',
                ];
            }
            return ['count' => 0, 'status' => 'error', 'message' => 'Service unavailable'];
        } catch (\Exception $e) {
            return ['count' => 0, 'status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
