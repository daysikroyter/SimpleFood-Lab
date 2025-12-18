<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
  // API методы
  public function index()
  {
    $products = Product::with(['category'])->paginate(20);
    return response()->json($products);
  }

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

  public function store(Request $request)
  {
    $validated = $request->validate([
      'category_id' => 'required|exists:categories,id',
      'title' => 'required|string|max:255',
      'description' => 'required|string',
      'price' => 'required|numeric|min:0',
      'image' => 'nullable|string',
    ]);

    $product = Product::create($validated);
    return response()->json($product, 201);
  }

  public function update(Request $request, $id)
  {
    $product = Product::findOrFail($id);
    $product->update($request->all());
    return response()->json($product);
  }

  public function destroy($id)
  {
    Product::destroy($id);
    return response()->json(null, 204);
  }

  public function byCategory($categoryId)
  {
    $products = Product::where('category_id', $categoryId)->paginate(20);
    return response()->json($products);
  }

  public function showBySlug($slug)
  {
    $product = Product::where('slug', $slug)->firstOrFail();
    return response()->json($product);
  }
}
