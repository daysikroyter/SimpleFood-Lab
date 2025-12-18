<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AdminUserController extends Controller
{
    private $authServiceUrl = 'http://localhost:8001';

    public function index(Request $request)
    {
        $response = Http::get("{$this->authServiceUrl}/api/users", $request->all());

        return response()->json($response->json(), $response->status());
    }

    public function show($id)
    {
        $response = Http::get("{$this->authServiceUrl}/api/users/{$id}");

        return response()->json($response->json(), $response->status());
    }

    public function update(Request $request, $id)
    {
        $response = Http::put("{$this->authServiceUrl}/api/users/{$id}", $request->all());

        return response()->json($response->json(), $response->status());
    }

    public function destroy($id)
    {
        $response = Http::delete("{$this->authServiceUrl}/api/users/{$id}");

        return response()->json($response->json(), $response->status());
    }
}
