@extends('layouts.main')

@section('title', 'Каталог товаров')

@section('content')
    <section class="top">
        <div class="container">
            <h2 class="sr-only">Навигация по сайту</h2>
            <ul class="breadcrumbs">
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--disabled">Каталог товаров</span>
                </li>
            </ul>
        </div>
    </section>

    <section class="shop">
        <div class="container">
            <div class="shop__nav">
                <h1 class="shop__nav-title title">
                    Каталог продуктов
                </h1>

                <form class="shop__nav-form" action="{{ route('catalog') }}" method="GET">
                    @if ($currentCategory)
                        <input type="hidden" name="category" value="{{ $currentCategory->slug }}">
                    @endif
                    @if (request('price_from') !== null)
                        <input type="hidden" name="price_from" value="{{ request('price_from') }}">
                    @endif
                    @if (request('price_to') !== null)
                        <input type="hidden" name="price_to" value="{{ request('price_to') }}">
                    @endif

                    <button class="shop__nav-btn" type="button">
                        <span class="sr-only">открыть фильтр меню</span>
                    </button>

                    <select class="shop__filter-sort select-style" name="sort" onchange="this.form.submit()">
                        <option value="title_asc" {{ $sort === 'title_asc' ? 'selected' : '' }}>По названию (А–Я)</option>
                        <option value="title_desc" {{ $sort === 'title_desc' ? 'selected' : '' }}>По названию (Я–А)</option>
                        <option value="price_asc" {{ $sort === 'price_asc' ? 'selected' : '' }}>Сначала дешёвые</option>
                        <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Сначала дорогие</option>
                    </select>

                    <select class="shop__filter-sort select-style" name="per_page" onchange="this.form.submit()">
                        <option value="12" {{ $perPage == 12 ? 'selected' : '' }}>по 12</option>
                        <option value="24" {{ $perPage == 24 ? 'selected' : '' }}>по 24</option>
                        <option value="48" {{ $perPage == 48 ? 'selected' : '' }}>по 48</option>
                    </select>
                </form>
            </div>

            <div class="shop__inner">
                <ul class="shop__filters">
                    <li class="shop__filters-item shop__filters-item--close">
                        <button class="shop__filters-btn" type="button"></button>
                    </li>

                    <li class="shop__filters-item">
                        <h2 class="shop__title">
                            Категории
                        </h2>
                        <ul class="shop__filters-list shop__filters-content">
                            <li class="shop__item">
                                <a class="shop__link link {{ $currentCategory ? '' : 'link--active' }}"
                                    href="{{ route('catalog', array_merge(request()->except('page', 'category'), [])) }}">
                                    Все товары
                                </a>
                            </li>

                            @foreach ($categories as $category)
                                <li class="shop__item">
                                    <a class="shop__link link {{ $currentCategory && $currentCategory->id === $category->id ? 'link--active' : '' }}"
                                        href="{{ route('catalog', array_merge(request()->except('page'), ['category' => $category->slug])) }}">
                                        {{ $category->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="shop__filters-item">
                        <h2 class="shop__title">
                            Цена
                        </h2>

                        @if ($globalMaxPrice > 0)
                            <form class="shop__filters-form shop__filters-range shop__filters-content"
                                action="{{ route('catalog') }}" method="GET">
                                @if ($currentCategory)
                                    <input type="hidden" name="category" value="{{ $currentCategory->slug }}">
                                @endif
                                <input type="hidden" name="sort" value="{{ $sort }}">
                                <input type="hidden" name="per_page" value="{{ $perPage }}">

                                <div class="shop__rangle-box">
                                    <span class="shop__filters-inner">
                                        от
                                        <input type="number" name="price_from" class="js-input-from shop__filters-price"
                                            value="{{ $priceFrom }}">
                                    </span>
                                    <span class="shop__filters-inner">
                                        до
                                        <input type="number" name="price_to" class="js-input-to shop__filters-price"
                                            value="{{ $priceTo }}">
                                    </span>
                                </div>

                                <div class="range-slider">
                                    <input type="text" class="js-range-slider" value=""
                                        data-min="{{ $globalMinPrice }}" data-max="{{ $globalMaxPrice }}"
                                        data-from="{{ $priceFrom }}" data-to="{{ $priceTo }}">
                                </div>

                                <button type="submit" class="btn"
                                    style="margin-top: 10px; width: 100%; padding: 10px 0; display: block;">
                                    Применить
                                </button>
                            </form>
                        @else
                            <p>Товары отсутствуют, фильтр по цене недоступен.</p>
                        @endif
                    </li>

                </ul>

                <div class="shop__content">
                    @if ($products->isEmpty())
                        <p>Товаров по выбранным фильтрам не найдено.</p>
                    @else
                        <ul class="shop__content-list">
                            @foreach ($products as $product)
                                <li class="shop__content-item">
                                    <article class="product-card">
                                        <a class="product-card__link" href="{{ route('product.show', $product) }}">
                                            @if ($product->image)
                                                <img class="product-card__img" width="140" height="140"
                                                    src="{{ asset($product->image) }}" alt="{{ $product->title }}">
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

                        @if ($products->hasPages())
                            <ul class="pagination">
                                <li class="pagination__item">
                                    @if ($products->onFirstPage())
                                        <span
                                            class="pagination__link pagination__arrow pagination__arrow--prev pagination__arrow--disabled"></span>
                                    @else
                                        <a class="pagination__link pagination__arrow pagination__arrow--prev"
                                            href="{{ $products->previousPageUrl() }}"></a>
                                    @endif
                                </li>

                                @for ($page = 1; $page <= $products->lastPage(); $page++)
                                    <li class="pagination__item">
                                        <a class="pagination__link pagination__element {{ $page == $products->currentPage() ? 'pagination__link--active' : '' }}"
                                            href="{{ $products->url($page) }}">
                                            {{ $page }}
                                        </a>
                                    </li>
                                @endfor

                                <li class="pagination__item">
                                    @if ($products->hasMorePages())
                                        <a class="pagination__link pagination__element pagination__arrow"
                                            href="{{ $products->nextPageUrl() }}"></a>
                                    @else
                                        <span
                                            class="pagination__link pagination__arrow pagination__arrow--disabled"></span>
                                    @endif
                                </li>
                            </ul>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="app section">
        <div class="container">
            <div class="app__inner" style="background-image: url({{ asset('assets/images/app.jpg') }});">
                <div class="app__content">
                    <h2 class="title app__title">
                        Скачайте мобильное приложение
                    </h2>
                    <p class="app__text">
                        Рестораны, которые вы любите - в ваших руках. Устанавливайте приложение и заказывайте еду в любом
                        удобном месте.
                    </p>
                    <ul class="app__list">
                        <li class="app__item">
                            <a class="app__link" target="_blank" href="404-page.html" rel="noopener noreferrer">
                                <img class="app__img" width="120" height="40"
                                    src="{{ asset('assets/images/icons/appstore.svg') }}" alt="appstore">
                            </a>
                        </li>
                        <li class="app__item">
                            <a class="app__link" target="_blank" href="404-page.html" rel="noopener noreferrer">
                                <img class="app__img" width="135" height="40"
                                    src="{{ asset('assets/images/icons/googleplay.svg') }}" alt="googleplay">
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <section class="promotions">
        <div class="container">
            <h2 class="promotions__title title">
                Акции и скидки
            </h2>
            <ul class="promotions__list">
                <li class="promotions__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" src="{{ asset('assets/images/restaurants/1.jpg') }}"
                            width="370" height="300" alt="Blaze Pizza">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                Скидка 50% на вторую пиццу
                            </h3>
                        </div>
                    </article>
                </li>
                <li class="promotions__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" width="370" height="300"
                            src="{{ asset('assets/images/restaurants/5.jpg') }}" alt="KFC">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                Картошечка из KFC даром при заказе бургера
                            </h3>
                        </div>
                    </article>
                </li>
                <li class="promotions__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" width="370" height="300"
                            src="{{ asset('assets/images/restaurants/6.jpg') }}" alt="Star Burgers">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                Чёрные бургеры на чёрный день
                            </h3>
                        </div>
                    </article>
                </li>
            </ul>
        </div>
    </section>
@endsection
