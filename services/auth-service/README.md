# Auth Service

Микросервис аутентификации для SimpleFood application.

## Описание

Auth Service отвечает за:
- Регистрацию пользователей
- Аутентификацию и авторизацию
- Управление JWT токенами
- Сброс и восстановление паролей
- Управление сессиями пользователей

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
```

## API Endpoints

- `POST /api/register` - Регистрация нового пользователя
- `POST /api/login` - Аутентификация пользователя
- `POST /api/logout` - Выход из системы
- `POST /api/refresh` - Обновление токена
- `GET /api/user` - Получение информации о текущем пользователе
- `POST /api/password/reset` - Запрос на сброс пароля
- `POST /api/password/update` - Обновление пароля

## Тестирование

```bash
composer test
```

## Разработка

```bash
php artisan serve --port=8001
```

## Лицензия

MIT
