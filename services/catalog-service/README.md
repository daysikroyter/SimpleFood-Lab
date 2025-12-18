# Catalog Service

Микросервис каталога продуктов для SimpleFood application.

## Описание

Catalog Service отвечает за:
- Управление каталогом продуктов
- Категории продуктов
- Поиск и фильтрацию продуктов
- Отзывы и рейтинги продуктов
- Изображения и медиа продуктов
- Ценообразование и наличие товаров

## Требования

- PHP >= 8.2
- Composer
- SQLite или MySQL/PostgreSQL

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

# Загрузка тестовых данных
php artisan db:seed
```

## API Endpoints

- `GET /api/products` - Список всех продуктов
- `GET /api/products/{id}` - Детали продукта
- `GET /api/categories` - Список категорий
- `GET /api/categories/{id}/products` - Продукты по категории
- `POST /api/products/search` - Поиск продуктов
- `GET /api/products/{id}/reviews` - Отзывы о продукте
- `POST /api/products/{id}/reviews` - Добавление отзыва

## Тестирование

```bash
composer test
```

## Разработка

```bash
php artisan serve --port=8002
```

## Лицензия

MIT
