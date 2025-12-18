<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminOrderController extends Controller
{
    private $orderServiceUrl = 'http://localhost:8000';

    public function index(Request $request)
    {
        $response = Http::get("{$this->orderServiceUrl}/api/orders", $request->all());

        return response()->json($response->json(), $response->status());
    }

    public function show($id)
    {
        $response = Http::get("{$this->orderServiceUrl}/api/orders/{$id}");

        return response()->json($response->json(), $response->status());
    }

    public function update(Request $request, $id)
    {
        $response = Http::put("{$this->orderServiceUrl}/api/orders/{$id}", $request->all());

        return response()->json($response->json(), $response->status());
    }
}
