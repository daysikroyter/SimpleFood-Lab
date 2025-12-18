@extends('layouts.main')

@section('title', $product->title)

@section('content')

    <style>
        .product-arrow.product-next.slick-arrow,
        .product-arrow.product-prev.slick-arrow {
            display: none !important;
        }

        .explore__list .slick-slide,
        .explore__list .slick-track {
            width: auto !important;
        }
    </style>

    <section class="top">
        <div class="container">
            <h2 class="sr-only">Навигация по сайту</h2>
            <ul class="breadcrumbs">
                <li class="breadcrumbs__item">
                    <a class="breadcrumbs__link" href="{{ route('home') }}">Главная</a>
                </li>
                <li class="breadcrumbs__item breadcrumbs__item--responsive">
                    <a class="breadcrumbs__link" href="{{ route('catalog') }}">Каталог товаров</a>
                </li>
                <li class="breadcrumbs__item">
                    <span class="breadcrumbs__link breadcrumbs__link--disabled">
                        {{ $product->title }}
                    </span>
                </li>
            </ul>
        </div>
    </section>

    <section class="product">
        <div class="container">
            <div class="product__inner">
                <div class="product__slider">
                    <ul class="product__slider-list">
                        @for ($i = 0; $i < 3; $i++)
                            <li class="product__item">
                                <button class="product__item-btn" type="button">
                                    <img class="product__img" width="400" height="400"
                                        src="{{ asset($product->image) }}" alt="{{ $product->title }}">
                                </button>
                            </li>
                        @endfor
                    </ul>

                    <div class="product__slider-popup">
                        <button class="product__slider-btn" type="button"></button>
                        <ul class="product__slider-carousel">
                            @for ($i = 0; $i < 3; $i++)
                                <li class="product__item">
                                    <img class="product__slider-img" src="{{ asset($product->image) }}"
                                        alt="{{ $product->title }}">
                                </li>
                            @endfor
                        </ul>
                    </div>
                </div>

                <div class="product__info">
                    <h1 class="title product__title">
                        {{ $product->title }}
                    </h1>

                    <div class="star" data-rateyo-rating="{{ $product->average_rating ?? 0 }}"></div>

                    <strong class="product__price">
                        {{ number_format($product->price, 0, '.', ' ') }} лей
                    </strong>

                    <form class="product__form" method="POST" action="{{ route('cart.add', $product) }}">
                        @csrf
                        <input class="product__input select-style" name="quantity" type="number" value="1"
                            min="1" max="50">
                        <button class="product__btn btn" type="submit">
                            <svg class="subscribe-ico">
                                <use xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg#add-basket') }}"></use>
                            </svg>
                            Добавить в корзину
                        </button>
                    </form>

                    <h2 class="product__subtitle">
                        Доставка и оплата
                    </h2>
                    <ul class="product__container">
                        <li class="product__text">
                            Минимальная сумма заказа — 160 <span>лей</span>
                        </li>
                        <li class="product__text">
                            Время доставки заказа — 80–140 <span>мин.</span>
                        </li>
                        <li class="product__text">
                            Оплата осуществляется только банковской картой.
                        </li>
                        <li class="product__text">
                            Окончательная сумма заказа формируется после сбора товаров.
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="product__content">
            <div class="container">
                <div class="product__content-inner">
                    <ul class="product__tabs tabs">
                        <li class="product__tab-item">
                            <a class="product__tab tab tab--active link" href="#tab-6">
                                Описание
                            </a>
                        </li>
                        <li class="product__tab-item">
                            <a class="product__tab tab link" href="#tab-7">
                                Характеристики
                            </a>
                        </li>
                        <li class="product__tab-item">
                            <a class="product__tab tab link" href="#tab-8">
                                Отзывы <span>({{ $product->reviews->count() }})</span>
                            </a>
                        </li>
                    </ul>

                    <ul class="product__tabs-content tabs-inner">
                        <li id="tab-6" class="product__content-item tabs-content tabs-content--active">
                            <ul class="product__descr-list">
                                @if ($product->description)
                                    <li class="product__descr">
                                        {!! $product->description !!}
                                    </li>
                                @else
                                    <li class="product__descr">
                                        Описание для этого товара пока не добавлено.
                                    </li>
                                @endif
                            </ul>
                        </li>

                        <li id="tab-7" class="product__content-item tabs-content">
                            @if ($product->features)
                                {!! $product->features !!}
                            @else
                                <p>Характеристики для этого товара пока не добавлены.</p>
                            @endif
                        </li>

                        <li id="tab-8" class="product__content-item tabs-content">
                            <div class="product__reviews">
                                <span class="product__reviews-title">
                                    Мнения наших клиентов
                                </span>

                                @if ($product->reviews->isEmpty())
                                    <p class="product__blockquote-text" style="margin-bottom: 1.5rem;">
                                        Отзывов пока нет. Будьте первым!
                                    </p>
                                @else
                                    <ul class="product__reviews-list">
                                        @foreach ($product->reviews as $review)
                                            <li class="product__reviews-item">
                                                <blockquote class="product__blockquote">
                                                    <div class="product__blockquote-inner">
                                                        <img class="product__blockquote-img"
                                                            src="{{ asset('assets/images/user-img.jpg') }}"
                                                            alt="{{ $review->user->name }}">

                                                        <div class="product__blockquote-info">
                                                            <span class="product__author">
                                                                {{ $review->user->name }}
                                                            </span>
                                                            <time class="product__time">
                                                                {{ $review->created_at->format('d.m.Y') }}
                                                            </time>
                                                        </div>

                                                        <div class="product__star"
                                                            data-rateyo-rating="{{ $review->rating }}"></div>
                                                    </div>
                                                    <p class="product__blockquote-text">
                                                        {{ $review->comment }}
                                                    </p>
                                                </blockquote>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                                @auth
                                    <h3 class="product__reviews-title">
                                        Оставить отзыв
                                    </h3>

                                    @if (session('success'))
                                        <p style="color: green; margin-bottom: 1rem;">
                                            {{ session('success') }}
                                        </p>
                                    @endif

                                    @if ($errors->any())
                                        <ul style="color: red; margin-bottom: 1rem;">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    @endif

                                    <form class="product__reviews-form" method="POST"
                                        action="{{ route('product.reviews.store', $product) }}">
                                        @csrf

                                        <label class="product__label product__label--star">
                                            Ваша оценка *
                                            <div class="product__form-star" data-current-rating="{{ old('rating', 5) }}">
                                            </div>
                                            <input type="hidden" name="rating" value="{{ old('rating', 5) }}">
                                        </label>

                                        <div class="product__form-box">
                                            <label class="product__label--textarea">
                                                Ваш отзыв *
                                                <textarea class="product__textarea" name="comment" placeholder="Введите текст отзыва" required>{{ old('comment') }}</textarea>
                                            </label>
                                        </div>

                                        <button class="product__form-btn btn">Оставить отзыв</button>
                                    </form>
                                @else
                                    <p style="margin-top: 1.5rem;">
                                        Чтобы оставить отзыв, <a href="{{ route('login') }}"
                                            style="color: #ff6838; text-decoration: underline;">войдите</a>
                                        или <a href="{{ route('register') }}"
                                            style="color: #ff6838; text-decoration: underline;">зарегистрируйтесь</a>.
                                    </p>
                                @endauth
                            </div>
                        </li>

                </div>
                </li>
                </ul>
            </div>
        </div>
        </div>
    </section>

    <section class="explore section">
        <div class="container">
            <h2 class="title explore__title">
                Вас может заинтересовать
            </h2>

            @if ($exploreProducts->isEmpty())
                <p>Других товаров пока нет.</p>
            @else
                <ul class="explore__list">
                    @foreach ($exploreProducts as $expProduct)
                        <li class="explore__item">
                            <article class="product-card">
                                <a class="product-card__link" href="{{ route('product.show', $expProduct) }}">
                                    @if ($expProduct->image)
                                        <img class="product-card__img" width="140" height="140"
                                            src="{{ asset($expProduct->image) }}" alt="{{ $expProduct->title }}">
                                    @endif
                                </a>
                                <h3 class="product-card__title">
                                    {{ $expProduct->title }}
                                </h3>
                                <span class="product-card__price">
                                    {{ number_format($expProduct->price, 0, '.', ' ') }}
                                    <span>лей</span>
                                </span>
                                <button class="product-card__btn btn" type="button">
                                    В корзину
                                </button>
                            </article>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </section>
@endsection
