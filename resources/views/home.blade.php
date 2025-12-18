@extends('layouts.main')

@section('title', 'Главная')

@section('content')
    <section class="hero">
        <div class="container">
            <div class="hero__inner" style="background-image: url('{{ asset('assets/images/top-bg.png') }}');">
                <div class="hero__box">
                    <h1 class="sr-only">simple food - быстрая доставка еды</h1>
                    <h2 class="hero__title">
                        Доставка
                        <span>за 15 минут</span>
                    </h2>
                    <p class="hero__text">
                        Самый быстрый сервис доставки еды в вашем городе. Не уложимся в срок - доставка за наш счёт
                    </p>
                    <div class="hero__btn-box">
                        <a class="hero__btn btn" href="catalog.html">
                            Заказать
                        </a>
                        <a class="hero__link link link--before" href="catalog.html">
                            Подробнее
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="popular-categories section">
        <div class="container">
            <h2 class="title popular-categories__title">
                Популярные категории
            </h2>

            @if ($categories->isEmpty())
                <p>Пока нет категорий с товарами.</p>
            @else
                <ul class="popular-categories__tabs tabs">
                    @foreach ($categories as $category)
                        @php $tabId = 'tab-' . ($loop->index + 1); @endphp
                        <li class="popular-categories__tabs-item">
                            <a class="popular-categories__tab tab btn {{ $loop->first ? 'tab--active' : '' }}"
                                href="#{{ $tabId }}">
                                @if ($category->icon)
                                    <svg class="tab-ico">
                                        <use
                                            xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg#' . $category->icon) }}">
                                        </use>
                                    </svg>
                                @endif
                                {{ $category->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <ul class="popular-categories__content tabs-inner">
                    @foreach ($categories as $category)
                        @php $tabId = 'tab-' . ($loop->index + 1); @endphp
                        <li id="{{ $tabId }}"
                            class="popular-categories__content-item tabs-content {{ $loop->first ? 'tabs-content--active' : '' }}">
                            @if ($category->products->isEmpty())
                                <p class="popular-categories__empty">
                                    В этой категории пока нет товаров.
                                </p>
                            @else
                                <ul class="popular-categories__list">
                                    @foreach ($category->products as $product)
                                        <li class="popular-categories__item">
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
                            @endif
                        </li>
                    @endforeach
                </ul>

                <a class="popular-categories__link link link--before" href="{{ route('catalog') }}">
                    Показать еще
                </a>
            @endif
        </div>
    </section>


    <section class="features section">
        <div class="container">
            <div class="features__inner" style="background-image: url('{{ asset('assets/images/features-bg.png') }}');">
                <div class="features__box">
                    <h2 class="title features__title">
                        Оставайтесь дома, <br>
                        а мы позаботимся о еде
                    </h2>
                    <p class="features__text">
                        У нас есть вкусная еда и мы готовы доставить её к вам домой! Воспользуйтесь нашей доставкой прямо
                        сейчас и
                        получите
                        скиидку!
                    </p>
                    <ul class="features__list">
                        <li class="features__item features__item--watch">
                            Быстрая доставка за 15 минут
                        </li>
                        <li class="features__item features__item--delivery">
                            Вежливые курьеры
                        </li>
                        <li class="features__item features__item--shop">
                            Более 500 заведений
                        </li>
                    </ul>
                    <a class="features__link btn" href="404-page.html">Подробнее</a>
                </div>
            </div>
        </div>
    </section>

    <section class="restaurants section">
        <div class="container">
            <h2 class="restaurants__title title">
                Лучшие рестораны
            </h2>
            <ul class="restaurants__list">
                <li class="restaurants__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" src="{{ asset('assets/images/restaurants/1.jpg') }}"
                            width="370" height="300" alt="Blaze Pizza">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                Blaze Pizza
                            </h3>
                            <div class="restaurant-card__nav">
                                <span class="restaurant-card__time">11:00 - 22:00</span>
                                <a class="restaurant-card__link btn" href="404-page.html">
                                    <span class="sr-only">Узнать Подробнее</span>
                                    <svg class="arrow-right-ico">
                                        <use
                                            xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg') }}#arrow-right">
                                        </use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                </li>
                <li class="restaurants__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" width="370" height="300"
                            src="{{ asset('assets/images/restaurants/2.jpg') }}" alt="Pizza Runcho">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                Pizza Runcho
                            </h3>
                            <div class="restaurant-card__nav">
                                <span class="restaurant-card__time">12:00 - 21:00</span>
                                <a class="restaurant-card__link btn" href="404-page.html">
                                    <span class="sr-only">Узнать подробнее</span>
                                    <svg class="arrow-right-ico">
                                        <use
                                            xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg') }}#arrow-right">
                                        </use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                </li>
                <li class="restaurants__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" width="370" height="300"
                            src="{{ asset('assets/images/restaurants/3.jpg') }}" alt="Pizza Hut">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                Pizza Hut
                            </h3>
                            <div class="restaurant-card__nav">
                                <span class="restaurant-card__time">11:00 - 22:00</span>
                                <a class="restaurant-card__link btn" href="404-page.html">
                                    <span class="sr-only">Узнать подробнее</span>
                                    <svg class="arrow-right-ico">
                                        <use
                                            xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg') }}#arrow-right">
                                        </use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                </li>
                <li class="restaurants__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" width="370" height="300"
                            src="{{ asset('assets/images/restaurants/4.jpg') }}" alt="McDonald`s">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                McDonald`s
                            </h3>
                            <div class="restaurant-card__nav">
                                <span class="restaurant-card__time">06:00 - 23:00</span>
                                <a class="restaurant-card__link btn" href="404-page.html">
                                    <span class="sr-only">Узнать подробнее</span>
                                    <svg class="arrow-right-ico">
                                        <use
                                            xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg') }}#arrow-right">
                                        </use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                </li>
                <li class="restaurants__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" width="370" height="300"
                            src="{{ asset('assets/images/restaurants/5.jpg') }}" alt="KFC">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                KFC
                            </h3>
                            <div class="restaurant-card__nav">
                                <span class="restaurant-card__time">06:00 - 23:30</span>
                                <a class="restaurant-card__link btn" href="404-page.html">
                                    <span class="sr-only">Узнать подробнее</span>
                                    <svg class="arrow-right-ico">
                                        <use
                                            xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg') }}#arrow-right">
                                        </use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                </li>
                <li class="restaurants__item">
                    <article class="restaurant-card">
                        <img class="restaurant-card__img" width="370" height="300"
                            src="{{ asset('assets/images/restaurants/6.jpg') }}" alt="Star Burgers">
                        <div class="restaurant-card__box">
                            <h3 class="restaurant-card__title">
                                Star Burgers
                            </h3>
                            <div class="restaurant-card__nav">
                                <span class="restaurant-card__time">09:00 - 21:00</span>
                                <a class="restaurant-card__link btn" href="404-page.html">
                                    <span class="sr-only">Узнать подробнее</span>
                                    <svg class="arrow-right-ico">
                                        <use
                                            xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg') }}#arrow-right">
                                        </use>
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </article>
                </li>
            </ul>
        </div>
    </section>

    <section class="reviews section">
        <div class="container">
            <h2 class="title reviews__title">
                Отзывы клиентов
            </h2>
            <ul class="reviews__slider">
                <li class="reviews__item">
                    <div class="reviews__inner">
                        <img class="reviews__img" width="300" height="300"
                            src="{{ asset('assets/images/slide.jpg') }}" alt="Дарья">
                        <div class="reviews__box">
                            <blockquote class="reviews__blockquote">
                                <p class="reviews__text">
                                    SimpleFood - одна из лучших служб доставки продуктов из ресторанов в городе. Очень
                                    удобный сайт и приложение. Их доставщики очень вежливы и пунктуальны. Компания часто
                                    проводит акции и дарит скидки на доставку - однозначно рекомендую!
                                </p>
                            </blockquote>
                            <cite class="reviews__cite">
                                Дарья
                                <span>Ценитель вкусной еды</span>
                            </cite>
                        </div>
                    </div>
                </li>
                <li class="reviews__item">
                    <div class="reviews__inner">
                        <img class="reviews__img" width="300" height="300"
                            src="{{ asset('assets/images/slide.jpg') }}" alt="Дарья">
                        <div class="reviews__box">
                            <blockquote class="reviews__blockquote">
                                <p class="reviews__text">
                                    SimpleFood - одна из лучших служб доставки продуктов из ресторанов в городе. Очень
                                    удобный сайт и приложение. Их доставщики очень вежливы и пунктуальны. Компания часто
                                    проводит акции и дарит скидки на доставку - однозначно рекомендую!
                                </p>
                            </blockquote>
                            <cite class="reviews__cite">
                                Дарья
                                <span>Ценитель вкусной еды</span>
                            </cite>
                        </div>
                    </div>
                </li>
                <li class="reviews__item">
                    <div class="reviews__inner">
                        <img class="reviews__img" width="300" height="300"
                            src="{{ asset('assets/images/slide.jpg') }}" alt="Дарья">
                        <div class="reviews__box">
                            <blockquote class="reviews__blockquote">
                                <p class="reviews__text">
                                    SimpleFood - одна из лучших служб доставки продуктов из ресторанов в городе. Очень
                                    удобный сайт и приложение. Их доставщики очень вежливы и пунктуальны. Компания часто
                                    проводит акции и дарит скидки на доставку - однозначно рекомендую!
                                </p>
                            </blockquote>
                            <cite class="reviews__cite">
                                Дарья
                                <span>Ценитель вкусной еды</span>
                            </cite>
                        </div>
                    </div>
                </li>
                <li class="reviews__item">
                    <div class="reviews__inner">
                        <img class="reviews__img" width="300" height="300"
                            src="{{ asset('assets/images/slide.jpg') }}" alt="Дарья">
                        <div class="reviews__box">
                            <blockquote class="reviews__blockquote">
                                <p class="reviews__text">
                                    SimpleFood - одна из лучших служб доставки продуктов из ресторанов в городе. Очень
                                    удобный сайт и приложение. Их доставщики очень вежливы и пунктуальны. Компания часто
                                    проводит акции и дарит скидки на доставку - однозначно рекомендую!
                                </p>
                            </blockquote>
                            <cite class="reviews__cite">
                                Дарья
                                <span>Ценитель вкусной еды</span>
                            </cite>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    <section class="app section">
        <div class="container">
            <div class="app__inner" style="background-image: url('{{ asset('assets/images/app.jpg') }}');">
                <div class="app__content">
                    <h2 class="title app__title">
                        Скачайте мобильное приложение
                    </h2>
                    <p class="app__text">
                        Рестораны, которые вы любите - в ваших руках. Устанавливайте приложение и заказывайте еду в любом
                        удобном
                        месте.
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
@endsection
