@extends('layouts.main')

@section('title', 'Поиск: ' . e($query))

@section('content')
    <section class="top">
        <div class="container">
            <h2 class="sr-only">Навигация по сайту</h2>
            <ul class="breadcrumbs">
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a>
                </li>
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link" href="{{ route('catalog') }}">Каталог товаров</a>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--disabled">
                        Поиск
                    </span>
                </li>
            </ul>
        </div>
    </section>

    <section class="shop">
        <div class="container">
            <div class="shop__nav">
                <h1 class="shop__nav-title title">
                    Результаты поиска: «{{ $query }}»
                </h1>
            </div>

            <div class="shop__inner">
                <div class="shop__content" style="width: 100%;">
                    @if ($products->isEmpty())
                        <p>По запросу «{{ $query }}» ничего не найдено.</p>
                        <p style="margin-top: 10px;">
                            <a class="link" href="{{ route('catalog') }}">Вернуться в каталог</a>
                        </p>
                    @else
                        <ul class="shop__content-list">
                            @foreach ($products as $product)
                                <li class="shop__content-item">
                                    <article class="product-card">
                                        <a class="product-card__link" href="{{ route('product.show', $product) }}">
                                            @if ($product->image)
                                                <img class="product-card__img" width="140" height="140"
                                                     src="{{ asset($product->image) }}"
                                                     alt="{{ $product->title }}">
                                            @endif
                                        </a>
                                        <h3 class="product-card__title">
                                            {{ $product->title }}
                                        </h3>
                                        <span class="product-card__price">
                                            {{ number_format($product->price, 0, '.', ' ') }}
                                            <span>лей</span>
                                        </span>

                                        @auth
                                            <form method="POST" action="{{ route('cart.add', $product) }}">
                                                @csrf
                                                <input type="hidden" name="quantity" value="1">
                                                <button class="product-card__btn btn" type="submit">
                                                    В корзину
                                                </button>
                                            </form>
                                        @else
                                            <a class="product-card__btn btn" href="{{ route('login') }}">
                                                Войти, чтобы добавить
                                            </a>
                                        @endauth
                                    </article>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-4">
                            {{ $products->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
