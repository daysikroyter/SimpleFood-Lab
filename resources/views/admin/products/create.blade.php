<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Создать товар') }}
        </h2>
    </x-slot>

    <div class="py-8" style="margin-top: 2rem; padding-bottom: 2rem;">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8" style="margin-bottom: 0;">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form method="POST" action="{{ route('admin.products.store') }}">
                    @include('admin.products.form')
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
