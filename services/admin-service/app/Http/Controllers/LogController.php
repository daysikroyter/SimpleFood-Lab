<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $logPath = storage_path('logs/laravel.log');

        if (!File::exists($logPath)) {
            return response()->json([
                'logs' => [],
                'message' => 'No logs found'
            ]);
        }

        $logContent = File::get($logPath);
        $lines = explode("\n", $logContent);

        // Get last 100 lines by default
        $limit = $request->input('limit', 100);
        $logs = array_slice(array_reverse($lines), 0, $limit);

        return response()->json([
            'logs' => array_values(array_filter($logs)),
            'total' => count($lines)
        ]);
    }
}
