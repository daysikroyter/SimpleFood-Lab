<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
  public function index()
  {
    $products = Product::with('category')
      ->orderByDesc('id')
      ->paginate(20);

    return view('admin.products.index', compact('products'));
  }

  public function create()
  {
    $categories = Category::orderBy('title')->get();

    return view('admin.products.create', compact('categories'));
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'title'       => ['required', 'string', 'max:255'],
      'slug'        => ['nullable', 'string', 'max:255', 'unique:products,slug'],
      'category_id' => ['required', 'exists:categories,id'],
      'price'       => ['required', 'numeric', 'min:0'],
      'image'       => ['nullable', 'string', 'max:255'],
      'description' => ['nullable', 'string'],
      'features'    => ['nullable', 'string'],
    ]);

    if (empty($data['slug'])) {
      $data['slug'] = Str::slug($data['title']);
    }

    Product::create($data);

    return redirect()
      ->route('admin.products.index')
      ->with('success', 'Товар создан');
  }

  public function edit(Product $product)
  {
    $categories = Category::orderBy('title')->get();

    return view('admin.products.edit', compact('product', 'categories'));
  }

  public function update(Request $request, Product $product)
  {
    $data = $request->validate([
      'title'       => ['required', 'string', 'max:255'],
      'slug'        => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
      'category_id' => ['required', 'exists:categories,id'],
      'price'       => ['required', 'numeric', 'min:0'],
      'image'       => ['nullable', 'string', 'max:255'],
      'description' => ['nullable', 'string'],
      'features'    => ['nullable', 'string'],
    ]);

    if (empty($data['slug'])) {
      $data['slug'] = Str::slug($data['title']);
    }

    $product->update($data);

    return redirect()
      ->route('admin.products.index')
      ->with('success', 'Товар обновлён');
  }

  public function destroy(Product $product)
  {
    $product->delete();

    return redirect()
      ->route('admin.products.index')
      ->with('success', 'Товар удалён');
  }
}
