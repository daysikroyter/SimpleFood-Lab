<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Админ-панель') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __('Привет, админ!') }}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="{{ route('admin.categories.index') }}"
                    class="block bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <h3 class="text-lg font-semibold mb-2">Категории</h3>
                    <p class="text-sm text-gray-600">
                        Управление категориями блюд (название, слаг, иконка).
                    </p>
                </a>

                <a href="{{ route('admin.products.index') }}"
                    class="block bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <h3 class="text-lg font-semibold mb-2">Товары</h3>
                    <p class="text-sm text-gray-600">
                        Управление товарами (категория, цена, описание, характеристики, изображение).
                    </p>
                </a>

                <a href="{{ route('admin.reviews.index') }}"
                    class="block bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <h3 class="text-lg font-semibold mb-2">Отзывы</h3>
                    <p class="text-sm text-gray-600">
                        Модерация отзывов пользователей (удаление ненужных).
                    </p>
                </a>

                <a href="{{ route('admin.orders.index') }}"
                    class="block bg-white shadow-sm sm:rounded-lg p-6 hover:bg-gray-50">
                    <h3 class="text-lg font-semibold mb-2">Заказы</h3>
                    <p class="text-sm text-gray-600">
                        Просмотр и изменение статусов заказов и оплаты.
                    </p>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
