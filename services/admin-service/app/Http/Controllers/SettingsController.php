<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Cache::get('admin_settings', [
            'site_name' => 'SimpleFood',
            'site_description' => 'Food Delivery Service',
            'contact_email' => 'admin@simplefood.com',
            'currency' => 'USD',
            'tax_rate' => 10,
            'delivery_fee' => 5,
            'maintenance_mode' => false,
        ]);

        return response()->json($settings);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'sometimes|string|max:255',
            'site_description' => 'sometimes|string|max:500',
            'contact_email' => 'sometimes|email',
            'currency' => 'sometimes|string|max:3',
            'tax_rate' => 'sometimes|numeric|min:0|max:100',
            'delivery_fee' => 'sometimes|numeric|min:0',
            'maintenance_mode' => 'sometimes|boolean',
        ]);

        $currentSettings = Cache::get('admin_settings', []);
        $updatedSettings = array_merge($currentSettings, $validated);

        Cache::put('admin_settings', $updatedSettings);

        return response()->json($updatedSettings);
    }
}
