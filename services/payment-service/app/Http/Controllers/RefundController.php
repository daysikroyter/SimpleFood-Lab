<?php

namespace App\Http\Controllers;

use App\Models\Refund;
use App\Models\Payment;
use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'payment_id' => 'required|exists:payments,id',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string|max:500',
        ]);

        $payment = Payment::findOrFail($validated['payment_id']);

        if ($payment->status !== 'completed') {
            return response()->json([
                'message' => 'Can only refund completed payments'
            ], 400);
        }

        $refund = Refund::create([
            'payment_id' => $validated['payment_id'],
            'amount' => $validated['amount'],
            'reason' => $validated['reason'],
            'status' => 'pending',
        ]);

        return response()->json($refund, 201);
    }

    public function show($id)
    {
        $refund = Refund::with(['payment'])->findOrFail($id);

        return response()->json($refund);
    }

    public function approve($id)
    {
        $refund = Refund::findOrFail($id);

        if ($refund->status !== 'pending') {
            return response()->json([
                'message' => 'Can only approve pending refunds'
            ], 400);
        }

        $refund->update([
            'status' => 'approved',
            'processed_at' => now(),
        ]);

        // Update payment status
        $payment = $refund->payment;
        $payment->update(['status' => 'refunded']);

        return response()->json($refund);
    }

    public function reject($id)
    {
        $refund = Refund::findOrFail($id);

        if ($refund->status !== 'pending') {
            return response()->json([
                'message' => 'Can only reject pending refunds'
            ], 400);
        }

        $refund->update([
            'status' => 'rejected',
            'processed_at' => now(),
        ]);

        return response()->json($refund);
    }
}
