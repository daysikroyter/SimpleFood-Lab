<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Новая категория') }}
        </h2>
    </x-slot>

    <div class="py-8" style="margin-top: 2rem;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.categories.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Название
                        </label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
                               required>
                        @error('title')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">
                            Слаг (если пусто – сгенерируется из названия)
                        </label>
                        <input type="text" name="slug" value="{{ old('slug') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('slug')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700">
                            Иконка (key из SVG-спрайта, например: <code>burger</code>, <code>pizza</code>)
                        </label>
                        <input type="text" name="icon" value="{{ old('icon') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                        @error('icon')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.categories.index') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm text-gray-700 bg-white hover:bg-gray-50">
                            Отмена
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-sm text-white hover:bg-indigo-700" style="color: green;">
                            Создать
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
