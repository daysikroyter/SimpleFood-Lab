<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function index()
  {
    $cartItems = CartItem::paginate(15);

    return response()->json([
      'success' => true,
      'data' => $cartItems,
    ]);
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'product_id' => ['required', 'integer'],
      'quantity' => ['required', 'integer', 'min:1'],
      'user_id' => ['required', 'integer'],
    ]);

    $item = CartItem::firstOrNew([
      'user_id' => $data['user_id'],
      'product_id' => $data['product_id'],
    ]);

    $item->quantity = ($item->quantity ?? 0) + $data['quantity'];
    $item->save();

    return response()->json([
      'success' => true,
      'message' => 'Товар добавлен в корзину',
      'data' => $item,
    ]);
  }

  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'quantity' => ['required', 'integer', 'min:0'],
    ]);

    $item = CartItem::findOrFail($id);

    if ($data['quantity'] === 0) {
      $item->delete();
      return response()->json([
        'success' => true,
        'message' => 'Товар удалён из корзины',
      ]);
    }

    $item->update(['quantity' => $data['quantity']]);

    return response()->json([
      'success' => true,
      'message' => 'Корзина обновлена',
      'data' => $item,
    ]);
  }

  public function destroy($id)
  {
    $item = CartItem::findOrFail($id);
    $item->delete();

    return response()->json([
      'success' => true,
      'message' => 'Товар удалён из корзины',
    ]);
  }

  public function clear(Request $request)
  {
    $userId = $request->input('user_id');
    CartItem::where('user_id', $userId)->delete();

    return response()->json([
      'success' => true,
      'message' => 'Корзина очищена',
    ]);
  }

  public function userCart($userId)
  {
    $cartItems = CartItem::where('user_id', $userId)->get();

    return response()->json([
      'success' => true,
      'data' => $cartItems,
    ]);
  }
}
