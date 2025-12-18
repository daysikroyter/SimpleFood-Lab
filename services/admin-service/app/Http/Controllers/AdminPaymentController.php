<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminPaymentController extends Controller
{
    private $paymentServiceUrl = 'http://localhost:8004';

    public function index(Request $request)
    {
        $response = Http::get("{$this->paymentServiceUrl}/api/payments", $request->all());

        return response()->json($response->json(), $response->status());
    }

    public function show($id)
    {
        $response = Http::get("{$this->paymentServiceUrl}/api/payments/{$id}");

        return response()->json($response->json(), $response->status());
    }
}
