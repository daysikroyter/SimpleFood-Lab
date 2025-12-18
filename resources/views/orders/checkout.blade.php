<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Оформление заказа
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 0rem;">

            <div class="bg-white shadow sm:rounded-lg p-6" style="margin-bottom: 2rem;">
                <h3 class="text-lg font-semibold mb-4">Ваши товары</h3>

                <ul class="divide-y divide-gray-200 mb-4">
                    @foreach ($cartItems as $item)
                        <li class="py-2 flex justify-between items-center">
                            <div class="flex items-center gap-4">
                                <a href="{{ route('product.show', $item->product) }}">
                                    <img src="{{ asset($item->product->image) }}" width="50" height="50"
                                        alt="{{ $item->product->title }}"
                                        style="object-fit: cover; border-radius: 4px;">
                                </a>
                                <div>
                                    <div class="font-medium">
                                        {{ $item->product->title }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $item->quantity }} шт ×
                                        {{ number_format($item->product->price, 0, '.', ' ') }} лей
                                    </div>
                                </div>
                            </div>
                            <div class="font-semibold">
                                {{ number_format($item->product->price * $item->quantity, 0, '.', ' ') }} лей
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="text-right text-lg font-semibold">
                    Итого: {{ number_format($total, 0, '.', ' ') }} лей
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Контактные данные</h3>

                @if ($errors->any())
                    <ul class="mb-4 text-red-600 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>- {{ $error }}</li>
                        @endforeach
                    </ul>
                @endif

                <form method="POST" action="{{ route('checkout.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Имя *
                        </label>
                        <input type="text" name="customer_name" value="{{ old('customer_name', $user->name) }}"
                            required class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Телефон *
                        </label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required
                            class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Адрес доставки *
                        </label>
                        <input type="text" name="address" value="{{ old('address') }}" required
                            class="w-full border-gray-300 rounded">
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Способ оплаты *
                        </label>

                        @php
                            $paymentOld = old('payment_method', 'cash');
                        @endphp

                        <div class="space-y-1 text-sm">
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_method" value="cash"
                                    {{ $paymentOld === 'cash' ? 'checked' : '' }} class="mr-2">
                                Наличными курьеру
                            </label>
                            <br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_method" value="card_on_delivery"
                                    {{ $paymentOld === 'card_on_delivery' ? 'checked' : '' }} class="mr-2">
                                Картой при получении
                            </label>
                            <br>
                            <label class="inline-flex items-center">
                                <input type="radio" name="payment_method" value="online"
                                    {{ $paymentOld === 'online' ? 'checked' : '' }} class="mr-2">
                                Онлайн-оплата (пока как заглушка)
                            </label>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Комментарий к заказу
                        </label>
                        <textarea name="comment" rows="3" class="w-full border-gray-300 rounded">{{ old('comment') }}</textarea>
                    </div>

                    <button type="submit"
                        style="color: green; font-weight: 600; color: white; background-color: green; padding: 10px 15px; border-radius: 5px; text-decoration: none;">
                        Подтвердить заказ
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
