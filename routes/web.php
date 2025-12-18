<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Models\Category;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
  $categories = Category::with(['products' => function ($q) {
    $q->orderBy('id');
  }])->get();

  $categories = $categories->filter(fn($cat) => $cat->products->isNotEmpty());

  return view('home', compact('categories'));
})->name('home');

Route::get('/catalog', [CatalogController::class, 'index'])->name('catalog');

Route::get('/product/{product:slug}', [ProductController::class, 'show'])
  ->name('product.show');

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'admin'])->name('dashboard');

Route::middleware('auth')->group(function () {
  Route::post('/cart/add/{product}', [CartController::class, 'store'])
    ->name('cart.add');

  Route::patch('/cart/{item}', [CartController::class, 'update'])
    ->name('cart.update');

  Route::delete('/cart/{item}', [CartController::class, 'destroy'])
    ->name('cart.destroy');
});

Route::get('/search', [ProductController::class, 'search'])
  ->name('products.search');

Route::middleware('auth')->group(function () {
  Route::get('/checkout', [OrderController::class, 'create'])->name('checkout.create');
  Route::post('/checkout', [OrderController::class, 'store'])->name('checkout.store');
  Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});

Route::middleware(['auth', 'admin'])
  ->prefix('admin')
  ->name('admin.')
  ->group(function () {
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)
      ->only(['index', 'show', 'update']);
    Route::get('reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::delete('reviews/{review}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
  });

Route::middleware('auth')->group(function () {
  Route::post('/product/{product:slug}/reviews', [ProductReviewController::class, 'store'])
    ->name('product.reviews.store');

  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
