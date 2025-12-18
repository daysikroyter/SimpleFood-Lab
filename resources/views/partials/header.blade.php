<header class="header">
    <div class="overlay"></div>
    <div class="container">
        <nav class="nav">
            <a class="nav__logo logo" href="{{ route('home') }}">
                <img class="logo__img" src="{{ asset('assets/images/logo.svg') }}" alt="Логотип">
            </a>

            <ul class="menu nav__menu">
                <li class="menu__item">
                    <a class="menu__link link {{ request()->routeIs('home') ? 'link--active' : '' }}"
                        href="{{ route('home') }}">
                        Главная
                    </a>
                </li>
                <li class="menu__item">
                    <a class="menu__link link {{ request()->routeIs('catalog') ? 'link--activeDishess' : '' }}"
                        href="{{ route('catalog') }}">
                        Блюда
                    </a>
                </li>

                @guest
                    <li class="menu__item">
                        <a class="menu__link link" href="{{ route('login') }}">Log in</a>
                    </li>
                    <li class="menu__item">
                        <a class="menu__link link" href="{{ route('register') }}">Register</a>
                    </li>
                @endguest

                @auth
                    <li class="menu__item">
                        <a class="menu__link link" href="{{ route('profile.edit') }}">
                            {{ Auth::user()->name }}
                        </a>
                    </li>

                    @if (Auth::user()->is_admin)
                        <li class="menu__item">
                            <a class="menu__link link" href="{{ route('dashboard') }}">
                                Admin
                            </a>
                        </li>
                    @endif

                    <li class="menu__item">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="menu__link link"
                                style="background:none;border:none;padding:0;cursor:pointer;">
                                Log out
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>

            <ul class="user-nav">
                <li class="user-nav__item">
                    <button class="user-nav__btn link-ico js-open-search" type="button">
                        <span class="sr-only">открыть поиск</span>
                        <svg class="ico">
                            <use xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg#search') }}"></use>
                        </svg>
                    </button>
                </li>
                <li class="user-nav__item">
                    @php
                        $cartCount = 0;

                        if (auth()->check()) {
                            $cartCount = auth()->user()->cartItems()->sum('quantity');
                        }
                    @endphp

                    <a class="user-nav__btn link-ico" href="{{ route('profile.edit') }}#cart">
                        <span class="sr-only">открыть корзину</span>
                        <svg class="ico">
                            <use xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg#basket') }}"></use>
                        </svg>
                        <span class="user-nav__num">
                            {{ $cartCount }}
                        </span>
                    </a>
                </li>
            </ul>

            <button class="burger-btn" type="button">
                <span class="burger-btn__line"></span>
                <span class="burger-btn__line"></span>
                <span class="burger-btn__line"></span>
                <span class="sr-only">открыть Меню</span>
            </button>

            <nav class="menu-burger">
                <div class="menu-burger__box">
                    <a class="logo" href="{{ route('home') }}">
                        <img class="logo__img" src="{{ asset('assets/images/logo.svg') }}" alt="Логотип">
                    </a>
                </div>
                <button class="menu-burger__btn" type="button">
                    <span class="menu-burger__btn-line"></span>
                    <span class="menu-burger__btn-line"></span>
                    <span class="sr-only">закрыть меню</span>
                </button>

                <ul class="menu">
                    <li class="menu__item">
                        <a class="menu__link link {{ request()->routeIs('home') ? 'link--active' : '' }}"
                            href="{{ route('home') }}">
                            Главная
                        </a>
                    </li>
                    <li class="menu__item">
                        <a class="menu__link link {{ request()->routeIs('catalog') ? 'link--activeDishess' : '' }}"
                            href="{{ route('catalog') }}">
                            Блюда
                        </a>
                    </li>
                    <li class="menu__item">
                        <a class="menu__link link" href="404-page.html">Контакты</a>
                    </li>

                    @guest
                        <li class="menu__item">
                            <a class="menu__link link" href="{{ route('login') }}">Log in</a>
                        </li>
                    @endguest

                    @auth
                        <li class="menu__item">
                            <a class="menu__link link" href="{{ route('profile.edit') }}">
                                {{ Auth::user()->name }}
                            </a>
                        </li>

                        @if (Auth::user()->is_admin)
                            <li class="menu__item">
                                <a class="menu__link link" href="{{ route('dashboard') }}">
                                    Админка
                                </a>
                            </li>
                        @endif

                        <li class="menu__item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="menu__link link"
                                    style="background:none;border:none;padding:0;cursor:pointer;">
                                    Выйти
                                </button>
                            </form>
                        </li>
                    @endauth
                </ul>
            </nav>
        </nav>
        <div class="header-search" id="header-search" style="display:none;">
            <div class="container">
                <form class="header-search__form" action="{{ route('products.search') }}" method="GET"
                    style="display:flex;gap:10px;align-items:center;padding:10px 0;">
                    <input type="text" name="q" class="header-search__input" placeholder="Я ищу..." required
                        style="flex:1;border:1px solid #ddd;border-radius:4px;padding:8px 10px;">
                    <button type="submit" class="btn" style="padding:8px 15px; border:none; color:white; border-radius:4px; cursor:pointer;">
                        Найти
                    </button>
                    <button type="button" class="header-search__close" style="margin-left:10px;">
                        ✕
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const openBtn  = document.querySelector('.js-open-search');
    const searchEl = document.getElementById('header-search');
    const closeBtn = searchEl ? searchEl.querySelector('.header-search__close') : null;

    if (openBtn && searchEl) {
      openBtn.addEventListener('click', function () {
        searchEl.style.display = 'block';
        const input = searchEl.querySelector('input[name="q"]');
        if (input) {
          input.focus();
        }
      });
    }

    if (closeBtn && searchEl) {
      closeBtn.addEventListener('click', function () {
        searchEl.style.display = 'none';
      });
    }
  });
</script>

