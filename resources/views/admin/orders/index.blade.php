<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Заказы
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 0rem;">
            <div class="bg-white sm:rounded-lg shadow p-6">

                <form method="GET" action="{{ route('admin.orders.index') }}" class="mb-4 flex gap-4" style="align-items: end;justify-content: space-between;">
                    <div>
                        <label class="block text-sm text-gray-600 mb-1">Статус</label>
                        <select name="status" class="border-gray-300 rounded">
                            <option value="">Все</option>
                            @foreach ($statusOptions as $value => $label)
                                <option value="{{ $value }}" @selected($status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit"
                            class="px-4 py-2 bg-gray-800 text-white text-sm rounded">
                        Фильтровать
                    </button>
                </form>

                <style>
                  table th, table td {
                    padding: 0.5rem 1rem;
                    text-align: left;
                  }
                </style>

                @if ($orders->isEmpty())
                    <p>Заказов пока нет.</p>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm" style="width: 100%;">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left">ID</th>
                                    <th class="px-3 py-2 text-left">Пользователь</th>
                                    <th class="px-3 py-2 text-left">Сумма</th>
                                    <th class="px-3 py-2 text-left">Статус</th>
                                    <th class="px-3 py-2 text-left">Оплата</th>
                                    <th class="px-3 py-2 text-left">Создан</th>
                                    <th class="px-3 py-2 text-right">Действия</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach ($orders as $order)
                                    <tr>
                                        <td class="px-3 py-2">#{{ $order->id }}</td>
                                        <td class="px-3 py-2">
                                            {{ $order->user?->name ?? '—' }}<br>
                                            <span class="text-xs text-gray-500">
                                                {{ $order->customer_name }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ number_format($order->total_price, 0, '.', ' ') }} лей
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $order->status_label }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $order->payment_status_label }}
                                        </td>
                                        <td class="px-3 py-2">
                                            {{ $order->created_at->format('d.m.Y H:i') }}
                                        </td>
                                        <td class="px-3 py-2 text-right">
                                            <a href="{{ route('admin.orders.show', $order) }}"
                                               class="text-indigo-600 hover:underline">
                                                Открыть
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
