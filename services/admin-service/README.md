# Admin Service

Микросервис административной панели для SimpleFood application.

## Описание

Admin Service отвечает за:
- Управление пользователями и правами доступа
- Управление продуктами и категориями
- Мониторинг заказов и платежей
- Аналитика и отчеты
- Управление контентом
- Настройки системы
- Логирование и аудит действий

## Требования

- PHP >= 8.2
- Composer
- SQLite или MySQL/PostgreSQL
- Доступ к API всех микросервисов

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

# Создание администратора
php artisan admin:create
```

## API Endpoints

### Пользователи
- `GET /api/admin/users` - Список пользователей
- `GET /api/admin/users/{id}` - Детали пользователя
- `PUT /api/admin/users/{id}` - Обновить пользователя
- `DELETE /api/admin/users/{id}` - Удалить пользователя
- `POST /api/admin/users/{id}/ban` - Заблокировать пользователя

### Продукты
- `GET /api/admin/products` - Список продуктов
- `POST /api/admin/products` - Создать продукт
- `PUT /api/admin/products/{id}` - Обновить продукт
- `DELETE /api/admin/products/{id}` - Удалить продукт

### Категории
- `GET /api/admin/categories` - Список категорий
- `POST /api/admin/categories` - Создать категорию
- `PUT /api/admin/categories/{id}` - Обновить категорию
- `DELETE /api/admin/categories/{id}` - Удалить категорию

### Заказы
- `GET /api/admin/orders` - Список заказов
- `GET /api/admin/orders/{id}` - Детали заказа
- `PUT /api/admin/orders/{id}/status` - Обновить статус заказа

### Аналитика
- `GET /api/admin/analytics/overview` - Общая статистика
- `GET /api/admin/analytics/sales` - Статистика продаж
- `GET /api/admin/analytics/users` - Статистика пользователей
- `GET /api/admin/analytics/products` - Популярные продукты

### Настройки
- `GET /api/admin/settings` - Получить настройки
- `PUT /api/admin/settings` - Обновить настройки

## Тестирование

```bash
composer test
```

## Разработка

```bash
php artisan serve --port=8005
```

## Интеграции

Сервис взаимодействует со всеми микросервисами:
- **Auth Service** - управление пользователями
- **Catalog Service** - управление продуктами
- **Cart Service** - мониторинг корзин
- **Payment Service** - мониторинг платежей
- **Order Service** - управление заказами

## Безопасность

- Доступ только для администраторов
- Двухфакторная аутентификация
- Аудит всех действий
- Rate limiting для API
- CORS настройки

## Лицензия

MIT
