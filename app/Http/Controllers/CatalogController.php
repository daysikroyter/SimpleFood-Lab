<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
  public function index(Request $request)
  {
    $categories = Category::orderBy('title')->get();

    $query = Product::with('category');

    $currentCategory = null;
    if ($request->filled('category')) {
      $currentCategory = Category::where('slug', $request->get('category'))->first();
      if ($currentCategory) {
        $query->where('category_id', $currentCategory->id);
      }
    }

    $globalMinPrice = Product::min('price');
    $globalMaxPrice = Product::max('price');

    if ($globalMinPrice === null || $globalMaxPrice === null) {
      $globalMinPrice = 0;
      $globalMaxPrice = 0;
    }

    $priceFrom = $request->filled('price_from')
      ? (float) $request->get('price_from')
      : $globalMinPrice;

    $priceTo = $request->filled('price_to')
      ? (float) $request->get('price_to')
      : $globalMaxPrice;

    if ($priceFrom > 0) {
      $query->where('price', '>=', $priceFrom);
    }
    if ($priceTo > 0 && $priceTo >= $priceFrom) {
      $query->where('price', '<=', $priceTo);
    }

    $sort = $request->get('sort', 'title_asc');

    switch ($sort) {
      case 'title_desc':
        $query->orderBy('title', 'desc');
        break;
      case 'price_asc':
        $query->orderBy('price', 'asc');
        break;
      case 'price_desc':
        $query->orderBy('price', 'desc');
        break;
      default:
        $query->orderBy('title', 'asc');
        break;
    }

    $perPage = (int) $request->get('per_page', 12);
    if (! in_array($perPage, [12, 24, 48])) {
      $perPage = 12;
    }

    $products = $query->paginate($perPage)->withQueryString();

    return view('catalog', [
      'categories'      => $categories,
      'products'        => $products,
      'currentCategory' => $currentCategory,
      'sort'            => $sort,
      'perPage'         => $perPage,

      'globalMinPrice'  => $globalMinPrice,
      'globalMaxPrice'  => $globalMaxPrice,
      'priceFrom'       => $priceFrom,
      'priceTo'         => $priceTo,
    ]);
  }
}
