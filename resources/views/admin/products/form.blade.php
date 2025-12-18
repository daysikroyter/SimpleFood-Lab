@csrf

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">
        Название
    </label>
    <input type="text" name="title"
           value="{{ old('title', $product->title ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    @error('title')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">
        Слаг (если оставить пустым — сгенерируется)
    </label>
    <input type="text" name="slug"
           value="{{ old('slug', $product->slug ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    @error('slug')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">
        Категория
    </label>
    <select name="category_id"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
        <option value="">Выберите категорию</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}"
                @selected(old('category_id', $product->category_id ?? null) == $category->id)>
                {{ $category->title }}
            </option>
        @endforeach
    </select>
    @error('category_id')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">
        Цена
    </label>
    <input type="number" step="0.01" name="price"
           value="{{ old('price', $product->price ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    @error('price')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">
        Изображение (путь или URL)
    </label>
    <input type="text" name="image"
           value="{{ old('image', $product->image ?? '') }}"
           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
    <p class="text-xs text-gray-500 mt-1">
        Например: <code>assets/images/products/1.jpg</code> или полный URL.
    </p>
    @error('image')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-4">
    <label class="block text-sm font-medium text-gray-700">
        Описание
    </label>
    <textarea name="description" id="description-editor"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm rich-editor"
              rows="6">{{ old('description', $product->description ?? '') }}</textarea>
    @error('description')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="mb-6">
    <label class="block text-sm font-medium text-gray-700">
        Характеристики
    </label>
    <textarea name="features" id="features-editor"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm rich-editor"
              rows="6">{{ old('features', $product->features ?? '') }}</textarea>
    @error('features')
        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
</div>

<div class="flex justify-end space-x-3">
    <a href="{{ route('admin.products.index') }}"
       class="px-4 py-2 border rounded-md text-sm text-gray-700">
        Отмена
    </a>
    <button type="submit"
            class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-semibold hover:bg-indigo-700" style="color: green;">
        Сохранить
    </button>
</div>

<script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
<script>
    if (document.querySelector('#description-editor')) {
        CKEDITOR.replace('description-editor');
    }
    if (document.querySelector('#features-editor')) {
        CKEDITOR.replace('features-editor');
    }
</script>
