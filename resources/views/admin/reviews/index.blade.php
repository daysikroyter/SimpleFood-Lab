<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Отзывы к товарам') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-top: 2rem;">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <style>
              table td {
                text-align: center;
              }
            </style>

            <div class="bg-white shadow-sm sm:rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200" style="width: 100%;">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Товар</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Пользователь</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Оценка</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Комментарий</th>
                        <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Действия</th>
                    </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reviews as $review)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $review->id }}</td>
                            <td class="px-4 py-2 text-sm text-indigo-600">
                                <a href="{{ route('product.show', $review->product) }}" target="_blank">
                                    {{ $review->product->title }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                {{ $review->user->name }}<br>
                                <span class="text-xs text-gray-500">{{ $review->user->email }}</span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                {{ $review->rating }} / 5
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-900">
                                {{ \Illuminate\Support\Str::limit($review->comment, 80) }}
                            </td>
                            <td class="px-4 py-2 text-sm text-right">
                                <form action="{{ route('admin.reviews.destroy', $review) }}"
                                      method="POST"
                                      onsubmit="return confirm('Удалить этот отзыв?');">
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
                                Отзывов пока нет.
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $reviews->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
