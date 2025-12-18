<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  public function show(Product $product)
  {
    $product->load(['reviews.user']);

    $exploreProducts = Product::where('category_id', $product->category_id)
      ->where('id', '!=', $product->id)
      ->inRandomOrder()
      ->take(6)
      ->get();

    return view('product', [
      'product'         => $product,
      'exploreProducts' => $exploreProducts,
    ]);
  }

  public function search(Request $request)
  {
    $q = trim($request->get('q', ''));

    if ($q === '') {
      return redirect()->route('catalog');
    }

    $products = Product::with('category')
      ->where(function ($query) use ($q) {
        $query->where('title', 'like', "%{$q}%")
          ->orWhere('description', 'like', "%{$q}%");
      })
      ->orderBy('title')
      ->paginate(12)
      ->withQueryString();

    return view('products.search', [
      'query'    => $q,
      'products' => $products,
    ]);
  }
}
