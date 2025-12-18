<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
  public function index(Request $request)
  {
    $status = $request->query('status');

    $orders = Order::with('user')
      ->when($status, fn($q) => $q->where('status', $status))
      ->latest()
      ->paginate(20)
      ->withQueryString();

    return view('admin.orders.index', [
      'orders'        => $orders,
      'status'        => $status,
      'statusOptions' => Order::STATUSES,
    ]);
  }

  public function show(Order $order)
  {
    $order->load(['user', 'items.product']);

    return view('admin.orders.show', [
      'order'                => $order,
      'statusOptions'        => Order::STATUSES,
      'paymentStatusOptions' => Order::PAYMENT_STATUSES,
    ]);
  }

  public function update(Request $request, Order $order)
  {
    $data = $request->validate([
      'status' => [
        'required',
        Rule::in(array_keys(Order::STATUSES)),
      ],
      'payment_status' => [
        'required',
        Rule::in(array_keys(Order::PAYMENT_STATUSES)),
      ],
    ]);

    $order->update($data);

    return redirect()
      ->route('admin.orders.show', $order)
      ->with('success', 'Статусы заказа обновлены.');
  }
}
