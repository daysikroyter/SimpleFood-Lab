<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
  // API методы
  public function index()
  {
    $categories = Category::all();
    return response()->json($categories);
  }

  public function show($id)
  {
    $category = Category::with('products')->findOrFail($id);
    return response()->json($category);
  }

  public function createView(): View
  {
    $categories = Category::orderBy('id', 'desc')->get();
    return view('admin.categories.index', compact('categories'));
  }

  public function create(): View
  {
    return view('admin.categories.create');
  }

  public function store(Request $request): RedirectResponse
  {
    $data = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'slug'  => ['nullable', 'string', 'max:255'],
      'icon'  => ['nullable', 'string', 'max:255'],
    ]);

    if (empty($data['slug'])) {
      $data['slug'] = Str::slug($data['title']);
    } else {
      $data['slug'] = Str::slug($data['slug']);
    }

    $original = $data['slug'];
    $counter = 1;

    while (\App\Models\Category::where('slug', $data['slug'])->exists()) {
      $data['slug'] = $original . '-' . $counter;
      $counter++;
    }

    Category::create($data);

    return redirect()
      ->route('admin.categories.index')
      ->with('success', 'Категория создана успешно');
  }


  public function edit(Category $category): View
  {
    return view('admin.categories.edit', compact('category'));
  }

  public function update(Request $request, Category $category): RedirectResponse
  {
    $data = $request->validate([
      'title' => ['required', 'string', 'max:255'],
      'slug'  => ['nullable', 'string', 'max:255', 'unique:categories,slug,' . $category->id],
      'icon'  => ['nullable', 'string', 'max:255'],
    ]);

    if (empty($data['slug'])) {
      $data['slug'] = Str::slug($data['title']);
    }

    $category->update($data);

    return redirect()
      ->route('admin.categories.index')
      ->with('success', 'Категория обновлена');
  }

  public function destroy(Category $category): RedirectResponse
  {
    $category->delete();

    return redirect()
      ->route('admin.categories.index')
      ->with('success', 'Категория удалена');
  }
}
