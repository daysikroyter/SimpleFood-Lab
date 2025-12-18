<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <style>
        html {
            scroll-behavior: smooth;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" id="cart">
                <div class="max-w-3xl">
                    <h3 class="text-lg font-semibold mb-4">Моя корзина</h3>

                    @if (session('success'))
                        <p class="mb-4 text-green-600">
                            {{ session('success') }}
                        </p>
                    @endif

                    <style>
                        table th,
                        table td {
                            padding: 0.5rem;
                            text-align: left;
                        }
                    </style>

                    @if ($cartItems->isEmpty())
                        <p>Корзина пуста.</p>
                    @else
                        <table class="min-w-full divide-y divide-gray-200 text-sm" style="width: 100%;">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500">Товар</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500">Цена</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500">Кол-во</th>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500">Сумма</th>
                                    <th class="px-3 py-2 text-right font-medium text-gray-500">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php $total = 0; @endphp
                                @foreach ($cartItems as $item)
                                    @php
                                        $lineTotal = $item->product->price * $item->quantity;
                                        $total += $lineTotal;
                                    @endphp
                                    <tr>
                                        <td class="px-3 py-2">
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <a href="{{ route('product.show', $item->product) }}">
                                                    <img src="{{ asset($item->product->image) }}" width="50"
                                                        height="50" alt="{{ $item->product->title }}"
                                                        style="object-fit: cover; border-radius: 4px;">
                                                </a>
                                                <a href="{{ route('product.show', $item->product) }}">
                                                    {{ $item->product->title }}
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ number_format($item->product->price, 0, '.', ' ') }} лей
                                        </td>
                                        <td class="px-3 py-2">
                                            <form action="{{ route('cart.update', $item) }}" method="POST"
                                                class="inline-flex items-center space-x-2">
                                                @csrf
                                                @method('PATCH')
                                                <input type="number" name="quantity" min="0"
                                                    value="{{ $item->quantity }}" class="w-16 border-gray-300 rounded">
                                                <button type="submit" class="text-xs text-indigo-600 hover:underline"
                                                    style="margin-left: 0.5rem;">
                                                    Обновить
                                                </button>
                                            </form>
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ number_format($lineTotal, 0, '.', ' ') }} лей
                                        </td>
                                        <td class="px-3 py-2 text-right">
                                            <form action="{{ route('cart.destroy', $item) }}" method="POST"
                                                onsubmit="return confirm('Убрать товар из корзины?');"
                                                class="inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 hover:underline">
                                                    Удалить
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="bg-gray-50"
                            style="padding-top: 1rem; font-weight: 600; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; font-size: 20px; gap: 10px;">
                            <span>
                                Итого:
                            </span>
                            <span>
                                {{ number_format($total, 0, '.', ' ') }} лей
                            </span>
                        </div>
                    @endif
                </div>
                @if (!$cartItems->isEmpty())
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('checkout.create') }}"
                             style="color: green; font-weight: 600; color: white; background-color: green; padding: 10px 15px; border-radius: 5px; text-decoration: none;">
                            Оформить заказ
                        </a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
