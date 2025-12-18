<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Редактировать товар') }}: {{ $product->title }}
        </h2>
    </x-slot>

    <div class="py-8" style="padding: 2rem 0;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.products.update', $product) }}">
                    @method('PUT')
                    @include('admin.products.form', ['product' => $product])
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
