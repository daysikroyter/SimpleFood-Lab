<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('transactions')
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $payments,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|integer',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|in:card,paypal,cash',
            'card_token' => 'required_if:payment_method,card',
        ]);

        $payment = Payment::create([
            'order_id' => $validated['order_id'],
            'user_id' => $request->user()->id,
            'amount' => $validated['amount'],
            'currency' => 'USD',
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
        ]);

        // TODO: Process payment with Stripe/PayPal

        return response()->json([
            'success' => true,
            'data' => $payment,
        ], 201);
    }

    public function show($id)
    {
        $payment = Payment::with('transactions', 'refunds')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    public function confirm(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'completed',
        ]);

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }

    public function cancel(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'status' => 'cancelled',
        ]);

        return response()->json([
            'success' => true,
            'data' => $payment,
        ]);
    }
}
