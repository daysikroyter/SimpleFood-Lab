<x-guest-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-4">Welcome page</h1>
        <p>Здесь потом вставим твою верстку главной страницы.</p>

        @guest
            <div class="mt-4 flex gap-4">
                <a href="{{ route('login') }}" class="text-blue-600 underline">
                    Войти
                </a>
                <a href="{{ route('register') }}" class="text-blue-600 underline">
                    Регистрация
                </a>
            </div>
        @endguest

        @auth
            <div class="mt-4">
                <a href="{{ route('dashboard') }}" class="text-blue-600 underline">
                    Перейти в кабинет
                </a>
            </div>
        @endauth
    </div>
</x-guest-layout>
