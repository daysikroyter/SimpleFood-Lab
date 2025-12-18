<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminProductController extends Controller
{
    private $catalogServiceUrl = 'http://localhost:8002';

    public function index(Request $request)
    {
        $response = Http::get("{$this->catalogServiceUrl}/api/products", $request->all());

        return response()->json($response->json(), $response->status());
    }

    public function show($id)
    {
        $response = Http::get("{$this->catalogServiceUrl}/api/products/{$id}");

        return response()->json($response->json(), $response->status());
    }

    public function update(Request $request, $id)
    {
        $response = Http::put("{$this->catalogServiceUrl}/api/products/{$id}", $request->all());

        return response()->json($response->json(), $response->status());
    }
}
