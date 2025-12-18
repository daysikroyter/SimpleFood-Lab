<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['payment']);

        if ($request->has('payment_id')) {
            $query->where('payment_id', $request->payment_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $transactions = $query->latest()->paginate(20);

        return response()->json($transactions);
    }

    public function show($id)
    {
        $transaction = Transaction::with(['payment'])->findOrFail($id);

        return response()->json($transaction);
    }
}
