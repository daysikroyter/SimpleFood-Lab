<footer class="footer">
  <div class="footer__top">
    <div class="container">
      <div class="footer__top-inner">
        <div class="footer__top-form">
          <a class="logo footer__logo" href="index.html">
            <img class="logo__img" src="{{ asset('assets/images/logo.svg') }}" alt="Логотип">
          </a>
          <form class="footer__form">
            <label class="sr-only" for="email">email</label>
            <input class="footer__input" name="email" id="email" type="email" placeholder="Ваш email" required>
            <button class="footer__btn btn" type="submit">
              <svg class="subscribe-ico">
                <use xlink:href="{{ asset('assets/images/icons/sprites/sprite.svg#tg') }}"></use>
              </svg>
              Подписаться
            </button>
          </form>
        </div>
        <ul class="footer__list">
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">Как это работает</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">О нас</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">Скачать приложение</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="catalog.html">Продукты</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">Новости</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">Блог</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="catalog.html">Блюда</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">Партнеры</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">Что нового?</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="catalog.html">Меню</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">ЧаВо</a>
          </li>
          <li class="footer__item">
            <a class="footer__link link" href="404-page.html">Карта сайта</a>
          </li>
        </ul>
        <address class="address">
          <ul class="address__list">
            <li class="address__item">
              <a class="address__link link address__link--location" href="https://yandex.ru/maps/-/CDVQZ029" target="_blank" rel="noopener noreferrer">ул. Т.Г.Шевченко, 1</a>
            </li>
            <li class="address__item">
              <a class="address__link link address__link--phone" href="tel:+380501112233">380501112233</a>
            </li>
            <li class="address__item">
              <a class="address__link link address__link--email" href="mailto:support@sfood.com">support@sfood.com</a>
            </li>
          </ul>
          <ul class="social">
            <li class="social__item">
              <a class="social__link link-ico" target="_blank" href="404-page.html" rel="noopener noreferrer">
                <span class="sr-only">Перейти в facebook</span>
                <span class="social__link-ico"
                  style="background-image: url('{{ asset('assets/images/icons/facebook.svg') }}'); width: 10px; height: 20px;"></span>
              </a>
            </li>
            <li class="social__item">
              <a class="social__link link-ico" target="_blank" href="404-page.html" rel="noopener noreferrer">
                <span class="sr-only">Перейти в twitter</span>
                <span class="social__link-ico"
                  style="background-image: url('{{ asset('assets/images/icons/twitter.svg') }}'); width: 20px; height: 17px;"></span>
              </a>
            </li>
            <li class="social__item">
              <a class="social__link link-ico" target="_blank" href="404-page.html" rel="noopener noreferrer">
                <span class="sr-only">Перейти в instagram</span>
                <span class="social__link-ico" style="background-image: url('{{ asset('assets/images/icons/instagram.svg') }}'); width: 20px; height: 20px;"></span>
              </a>
            </li>
          </ul>
        </address>
      </div>
    </div>
  </div>
  <p class="footer__copy">
    © 2022 Simple Food
  </p>
</footer>