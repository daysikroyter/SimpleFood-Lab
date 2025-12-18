<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\CartItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
  public function create()
  {
    $user = auth()->user();

    $cartItems = CartItem::with('product')
      ->where('user_id', $user->id)
      ->get();

    if ($cartItems->isEmpty()) {
      return redirect()
        ->route('profile.edit')
        ->with('success', 'Корзина пуста');
    }

    $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

    return view('orders.checkout', [
      'user' => $user,
      'cartItems' => $cartItems,
      'total' => $total,
    ]);
  }

  public function store(Request $request)
  {
    $user = auth()->user();

    $data = $request->validate([
      'customer_name' => ['required', 'string', 'max:255'],
      'phone' => ['nullable', 'string', 'max:50'],
      'address' => ['nullable', 'string', 'max:255'],
      'comment' => ['nullable', 'string'],
    ]);

    $cartItems = CartItem::with('product')
      ->where('user_id', $user->id)
      ->get();

    if ($cartItems->isEmpty()) {
      return redirect()
        ->route('profile.edit')
        ->with('success', 'Корзина пуста');
    }

    DB::transaction(function () use ($user, $data, $cartItems) {
      $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

      $order = Order::create([
        'user_id' => $user->id,
        'total_price' => $total,
        'status' => 'new',
        'payment_method' => 'cash',
        'payment_status' => 'unpaid',
        'customer_name' => $data['customer_name'],
        'phone' => $data['phone'] ?? null,
        'address' => $data['address'] ?? null,
        'meta' => [
          'comment' => $data['comment'] ?? null,
        ],
      ]);

      foreach ($cartItems as $item) {
        $unitPrice = $item->product->price;
        $lineTotal = $unitPrice * $item->quantity;

        OrderItem::create([
          'order_id' => $order->id,
          'product_id' => $item->product_id,
          'product_title' => $item->product->title,
          'unit_price' => $unitPrice,
          'quantity' => $item->quantity,
          'line_total' => $lineTotal,
        ]);
      }

      CartItem::where('user_id', $user->id)->delete();
    });

    return redirect()
      ->route('profile.edit')
      ->with('success', 'Заказ успешно оформлен!');
  }
}
