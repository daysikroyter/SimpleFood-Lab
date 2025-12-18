<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response()->json([
        'service' => 'Catalog Service',
        'status' => 'running',
        'version' => '1.0.0'
    ]);
});

Route::get('/health', function () {
    return response()->json(['status' => 'ok']);
});
