<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Товары') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 2rem;">

            @if (session('success'))
                <div class="mb-4 rounded-md bg-green-100 py-3 text-sm text-green-800">
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold">Список товаров</h3>
                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700" style="color: green;">
                    + Добавить товар
                </a>
            </div>

            <style>
              td {
                text-align: center;
              }
            </style>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200" style="width: 100%;">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Название</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Категория</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Цена</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Слаг</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $product->id }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $product->title }}</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $product->category->title ?? '—' }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $product->price }} грн.</td>
                            <td class="px-4 py-2 text-sm text-gray-500">{{ $product->slug }}</td>
                            <td class="px-4 py-2 text-sm text-right space-x-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="text-indigo-600 hover:text-indigo-900">
                                    Редактировать
                                </a>

                                <form action="{{ route('admin.products.destroy', $product) }}"
                                      method="POST" class="inline-block"
                                      onsubmit="return confirm('Удалить товар?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        Удалить
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-4 text-center text-sm text-gray-500">
                                Товаров пока нет.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
