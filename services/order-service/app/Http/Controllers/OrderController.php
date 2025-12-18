<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
  public function index()
  {
    $orders = Order::with('items')->latest()->paginate(15);

    return response()->json([
      'success' => true,
      'data' => $orders,
    ]);
  }

  public function show($id)
  {
    $order = Order::with('items')->findOrFail($id);

    return response()->json([
      'success' => true,
      'data' => $order,
    ]);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'user_id' => ['required', 'integer'],
      'customer_name' => ['required', 'string', 'max:255'],
      'phone' => ['nullable', 'string', 'max:50'],
      'address' => ['nullable', 'string', 'max:255'],
      'comment' => ['nullable', 'string'],
      'items' => ['required', 'array'],
      'items.*.product_id' => ['required', 'integer'],
      'items.*.product_title' => ['required', 'string'],
      'items.*.unit_price' => ['required', 'numeric'],
      'items.*.quantity' => ['required', 'integer', 'min:1'],
    ]);

    $order = DB::transaction(function () use ($data) {
      $total = collect($data['items'])->sum(function ($item) {
        return $item['unit_price'] * $item['quantity'];
      });

      $order = Order::create([
        'user_id' => $data['user_id'],
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

      foreach ($data['items'] as $item) {
        OrderItem::create([
          'order_id' => $order->id,
          'product_id' => $item['product_id'],
          'product_title' => $item['product_title'],
          'unit_price' => $item['unit_price'],
          'quantity' => $item['quantity'],
          'line_total' => $item['unit_price'] * $item['quantity'],
        ]);
      }

      return $order;
    });

    return response()->json([
      'success' => true,
      'message' => 'Заказ успешно создан',
      'data' => $order->load('items'),
    ], 201);
  }

  public function destroy($id)
  {
    $order = Order::findOrFail($id);
    $order->delete();

    return response()->json([
      'success' => true,
      'message' => 'Заказ удалён',
    ]);
  }

  public function updateStatus(Request $request, $id)
  {
    $data = $request->validate([
      'status' => ['required', 'string', 'in:new,confirmed,preparing,ready,delivering,delivered,cancelled'],
    ]);

    $order = Order::findOrFail($id);
    $order->update(['status' => $data['status']]);

    return response()->json([
      'success' => true,
      'message' => 'Статус заказа обновлён',
      'data' => $order,
    ]);
  }
}
