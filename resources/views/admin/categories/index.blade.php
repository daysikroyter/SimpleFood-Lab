<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Категории') }}
        </h2>
    </x-slot>

    <style>
      td {
        text-align: center;
      }
    </style>

    <div class="py-8">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="margin: 2rem auto 0;">
                    {{ session('success') }}
                </div>
            @endif

            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" style="margin: 0 auto;">
                <div class="flex justify-between items-center mb-4 mt-3">
                    <h3 class="text-lg font-semibold">Список категорий</h3>
                    <a href="{{ route('admin.categories.create') }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700"
                        style="color: black;">
                        + Добавить категорию
                    </a>
                </div>

                <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200" style="width: 100%;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    ID
                                </th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Название
                                </th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Слаг
                                </th>
                                <th
                                    class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Иконка (key)
                                </th>
                                <th
                                    class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Действия
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr>
                                    <td class="px-4 py-2 text-sm text-gray-900">
                                        {{ $category->id }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-900">
                                        {{ $category->title }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500">
                                        {{ $category->slug }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-500">
                                        {{ $category->icon }}
                                    </td>
                                    <td class="px-4 py-2 text-sm text-right space-x-2">
                                        <a href="{{ route('admin.categories.edit', $category) }}"
                                            class="text-indigo-600 hover:text-indigo-900">
                                            Редактировать
                                        </a>

                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            class="inline-block" onsubmit="return confirm('Удалить категорию?');">
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
                                    <td colspan="5" class="px-4 py-4 text-center text-sm text-gray-500">
                                        Категорий пока нет.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
</x-app-layout>
