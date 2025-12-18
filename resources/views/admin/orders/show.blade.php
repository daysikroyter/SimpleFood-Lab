<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Заказ #{{ $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 0rem;">

            <div class="bg-white shadow sm:rounded-lg p-6" style="margin-bottom: 2rem;">
                @if (session('success'))
                    <p class="mb-4 text-green-600 text-sm">{{ session('success') }}</p>
                @endif

                <h3 class="text-lg font-semibold mb-4">Информация о заказе</h3>

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <dt class="font-medium text-gray-500">Пользователь</dt>
                        <dd>{{ $order->user?->name ?? '—' }} (ID: {{ $order->user_id }})</dd>
                    </div>

                    <div>
                        <dt class="font-medium text-gray-500">Имя клиента</dt>
                        <dd>{{ $order->customer_name }}</dd>
                    </div>

                    <div>
                        <dt class="font-medium text-gray-500">Телефон</dt>
                        <dd>{{ $order->phone ?: '—' }}</dd>
                    </div>

                    <div>
                        <dt class="font-medium text-gray-500">Адрес</dt>
                        <dd>{{ $order->address ?: '—' }}</dd>
                    </div>

                    <div>
                        <dt class="font-medium text-gray-500">Сумма</dt>
                        <dd>{{ number_format($order->total_price, 0, '.', ' ') }} лей</dd>
                    </div>

                    <div>
                        <dt class="font-medium text-gray-500">Метод оплаты</dt>
                        <dd>{{ $order->payment_method }}</dd>
                    </div>
                </dl>

                @if (!empty($order->meta['comment']))
                    <div class="mt-4">
                        <dt class="font-medium text-gray-500">Комментарий клиента</dt>
                        <dd class="text-sm">{{ $order->meta['comment'] }}</dd>
                    </div>
                @endif
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6" style="margin-bottom: 2rem;">
                <h3 class="text-lg font-semibold mb-4">Товары</h3>

                <style>
                    table th,
                    table td {
                        padding: 0.5rem;
                        text-align: center;
                    }
                </style>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm" style="width: 100%;">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left">Товар</th>
                                <th class="px-3 py-2 text-left">Кол-во</th>
                                <th class="px-3 py-2 text-left">Цена за шт.</th>
                                <th class="px-3 py-2 text-left">Сумма</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($order->items as $item)
                                <tr>
                                    <td class="px-3 py-2">
                                        @if ($item->product)
                                            <div
                                                style="display: flex; align-items: center; gap: 10px; justify-content: center;">
                                                <a href="{{ route('product.show', $item->product) }}">
                                                    <img src="{{ asset($item->product->image) }}" width="50"
                                                        height="50" alt="{{ $item->product->title }}"
                                                        style="object-fit: cover; border-radius: 4px;">
                                                </a>
                                                <a href="{{ route('product.show', $item->product) }}"
                                                    class="text-indigo-600 hover:underline">
                                                    {{ $item->product_title }}
                                                </a>
                                            </div>
                                        @else
                                            {{ $item->product_title }}
                                        @endif
                                    </td>
                                    <td class="px-3 py-2">{{ $item->quantity }}</td>
                                    <td class="px-3 py-2">
                                        {{ number_format($item->unit_price, 0, '.', ' ') }} лей
                                    </td>
                                    <td class="px-3 py-2">
                                        {{ number_format($item->line_total, 0, '.', ' ') }} лей
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Изменить статусы</h3>

                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="space-y-4">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <ul class="mb-4 text-red-600 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>- {{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif

                    <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Статус заказа
                            </label>
                            <select name="status" class="border-gray-300 rounded">
                                @foreach ($statusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($order->status === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Статус оплаты
                            </label>
                            <select name="payment_status" class="border-gray-300 rounded">
                                @foreach ($paymentStatusOptions as $value => $label)
                                    <option value="{{ $value }}" @selected($order->payment_status === $value)>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="px-4 py-2 bg-gray-800 text-white text-sm rounded">
                        Сохранить
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
