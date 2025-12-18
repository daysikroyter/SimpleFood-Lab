<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductReviewController extends Controller
{
  public function store(Request $request, Product $product)
  {
    $data = $request->validate([
      'rating' => ['required', 'numeric', 'between:1,5'],
      'comment' => ['required', 'string', 'max:5000'],
    ]);

    ProductReview::create([
      'product_id' => $product->id,
      'user_id'    => Auth::id(),
      'rating'     => $data['rating'],
      'comment'    => $data['comment'],
    ]);

    return redirect()
      ->route('product.show', $product)
      ->with('success', 'Спасибо за ваш отзыв!');
  }
}
