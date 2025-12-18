# Локальный запуск без Docker (через Laragon)

## Предварительные требования

- **Laragon** установлен и запущен
- **MySQL** работает (через Laragon)
- **PHP 8.2+** доступен в PATH

## Шаг 1: Настройка .env файлов

Откройте `.env` в каждом сервисе и проверьте настройки MySQL:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=auth_db       # Для каждого сервиса своя БД
DB_USERNAME=root
DB_PASSWORD=              # Ваш пароль от MySQL в Laragon
```

Базы данных для сервисов:
- `auth-service` → `auth_db`
- `catalog-service` → `catalog_db`
- `cart-service` → `cart_db`
- `order-service` → `orders_db`
- `payment-service` → `payments_db`
- `admin-service` → `admin_db`

## Шаг 2: Создание баз данных

Откройте **HeidiSQL** из Laragon и выполните:

```sql
CREATE DATABASE IF NOT EXISTS auth_db;
CREATE DATABASE IF NOT EXISTS catalog_db;
CREATE DATABASE IF NOT EXISTS cart_db;
CREATE DATABASE IF NOT EXISTS orders_db;
CREATE DATABASE IF NOT EXISTS payments_db;
CREATE DATABASE IF NOT EXISTS admin_db;
```

## Шаг 3: Автоматическая настройка

Запустите скрипт настройки:

```bash
scripts\local-setup.bat
```

Этот скрипт:
1. Создаст .env файлы
2. Сгенерирует APP_KEY для каждого сервиса
3. Напомнит создать базы данных
4. Запустит миграции

## Шаг 4: Запуск сервисов

Запустите все микросервисы:

```bash
scripts\local-start.bat
```

Откроется 7 окон терминала (по одному для каждого сервиса).

## Проверка работы

Откройте в браузере:
- http://localhost:9000/health (API Gateway)
- http://localhost:8001/health (Auth Service)
- http://localhost:8002/health (Catalog Service)
- http://localhost:8003/health (Cart Service)
- http://localhost:8000/health (Order Service)
- http://localhost:8004/health (Payment Service)
- http://localhost:8005/health (Admin Service)

## Остановка сервисов

Нажмите `Ctrl+C` в каждом окне терминала или просто закройте все окна.

## Примечания

⚠️ **Redis**: Если нужен Redis для кеширования (Cart Service), установите Redis через Laragon или закомментируйте `CACHE_DRIVER=redis` в .env (используйте `file` вместо `redis`).

⚠️ **RabbitMQ**: Для работы очередей между сервисами нужен RabbitMQ. Можно использовать `sync` драйвер для разработки:
```env
QUEUE_CONNECTION=sync
```

⚠️ **URLs сервисов**: В Admin Service контроллеры используют внутренние URL типа `http://auth-service:8001`. Для локального запуска замените на `http://localhost:8001` в файлах контроллеров или добавьте в .env:

```env
AUTH_SERVICE_URL=http://localhost:8001
CATALOG_SERVICE_URL=http://localhost:8002
CART_SERVICE_URL=http://localhost:8003
ORDER_SERVICE_URL=http://localhost:8000
PAYMENT_SERVICE_URL=http://localhost:8004
```
