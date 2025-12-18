<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'service' => 'Cart Service',
        'status' => 'running',
        'version' => '1.0.0'
    ]);
});

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
