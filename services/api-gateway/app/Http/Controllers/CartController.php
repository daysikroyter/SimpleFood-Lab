<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
  public function store(Request $request, Product $product)
  {
    $data = $request->validate([
      'quantity' => ['required', 'integer', 'min:1'],
    ]);

    $item = CartItem::firstOrNew([
      'user_id' => auth()->id(),
      'product_id' => $product->id,
    ]);

    $item->quantity = ($item->quantity ?? 0) + $data['quantity'];
    $item->save();

    return back()->with('success', 'Товар добавлен в корзину');
  }

  public function update(Request $request, CartItem $item)
  {
    abort_if($item->user_id !== auth()->id(), 403);

    $data = $request->validate([
      'quantity' => ['required', 'integer', 'min:0'],
    ]);

    if ($data['quantity'] === 0) {
      $item->delete();
    } else {
      $item->update(['quantity' => $data['quantity']]);
    }

    return back()->with('success', 'Корзина обновлена');
  }

  public function destroy(CartItem $item)
  {
    abort_if($item->user_id !== auth()->id(), 403);

    $item->delete();

    return back()->with('success', 'Товар удалён из корзины');
  }
}
