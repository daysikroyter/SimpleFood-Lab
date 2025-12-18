# Cart Service

Микросервис корзины покупок для SimpleFood application.

## Описание

Cart Service отвечает за:
- Управление корзиной пользователя
- Добавление/удаление товаров из корзины
- Обновление количества товаров
- Расчет общей стоимости
- Применение промокодов и скидок
- Синхронизация с каталогом продуктов

## Требования

- PHP >= 8.2
- Composer
- SQLite или MySQL/PostgreSQL
- Redis (опционально, для кеширования)

## Установка

```bash
# Установка зависимостей
composer install

# Копирование .env файла
cp .env.example .env

# Генерация ключа приложения
php artisan key:generate

# Запуск миграций
php artisan migrate
```

## API Endpoints

- `GET /api/cart` - Получить корзину пользователя
- `POST /api/cart/items` - Добавить товар в корзину
- `PUT /api/cart/items/{id}` - Обновить количество товара
- `DELETE /api/cart/items/{id}` - Удалить товар из корзины
- `DELETE /api/cart` - Очистить корзину
- `POST /api/cart/apply-coupon` - Применить промокод
- `GET /api/cart/total` - Получить общую стоимость

## Тестирование

```bash
composer test
```

## Разработка

```bash
php artisan serve --port=8003
```

## Интеграции

Сервис взаимодействует с:
- **Catalog Service** - для получения информации о продуктах
- **Auth Service** - для аутентификации пользователей

## Лицензия

MIT
