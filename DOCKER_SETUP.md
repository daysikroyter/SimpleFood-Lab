# Запуск через Docker Desktop

## Шаг 1: Установка Docker Desktop
Скачайте и установите [Docker Desktop](https://www.docker.com/products/docker-desktop)

## Шаг 2: Подготовка .env файлов
Убедитесь, что в каждом сервисе есть файл `.env`:

```bash
# Скопируйте .env.example в .env для каждого сервиса
cd services/auth-service && cp .env.example .env
cd ../catalog-service && cp .env.example .env
cd ../cart-service && cp .env.example .env
cd ../order-service && cp .env.example .env
cd ../payment-service && cp .env.example .env
cd ../admin-service && cp .env.example .env
```

## Шаг 3: Запуск через Docker Desktop

### Вариант 1: Через интерфейс Docker Desktop
1. Откройте **Docker Desktop**
2. В главном меню выберите папку вашего проекта `SimpleFood-monolith`
3. Docker Desktop автоматически найдёт `docker-compose.yml`
4. Нажмите кнопку **"Start"** или используйте контекстное меню

### Вариант 2: Через командную строку
```bash
# В корне проекта SimpleFood-monolith
docker-compose up -d
```

## Шаг 4: Проверка запущенных контейнеров
В Docker Desktop откройте вкладку **Containers** и убедитесь, что все сервисы запущены:

- simplefood-api-gateway (порт 9000)
- simplefood-auth-service (порт 8001)  
- simplefood-catalog-service (порт 8002)
- simplefood-cart-service (порт 8003)
- simplefood-order-service (порт 8000)
- simplefood-payment-service (порт 8004)
- simplefood-admin-service (порт 8005)
- MySQL контейнеры для каждого сервиса
- Redis

## Шаг 5: Миграции баз данных
После запуска контейнеров выполните миграции:

```bash
# Auth Service
docker exec -it simplefood-auth-service php artisan migrate --force

# Catalog Service  
docker exec -it simplefood-catalog-service php artisan migrate --force

# Cart Service
docker exec -it simplefood-cart-service php artisan migrate --force

# Order Service
docker exec -it simplefood-order-service php artisan migrate --force

# Payment Service
docker exec -it simplefood-payment-service php artisan migrate --force

# Admin Service
docker exec -it simplefood-admin-service php artisan migrate --force
```

## Шаг 6: Проверка работы

Откройте в браузере:
- API Gateway: http://localhost:9000
- Auth Service: http://localhost:8001/api/users
- Catalog Service: http://localhost:8002/api/products
- Cart Service: http://localhost:8003/api/cart
- Order Service: http://localhost:8000/api/orders
- Payment Service: http://localhost:8004/api/payments
- Admin Service: http://localhost:8005/api/dashboard

## Остановка сервисов

### Через Docker Desktop
Нажмите кнопку **Stop** для контейнера или группы контейнеров

### Через командную строку
```bash
docker-compose down
```

## Просмотр логов

### В Docker Desktop
Выберите контейнер и откройте вкладку **Logs**

### Через командную строку
```bash
# Все сервисы
docker-compose logs -f

# Конкретный сервис
docker-compose logs -f auth-service
```

## Пересборка при изменении кода

```bash
# Пересобрать и перезапустить
docker-compose up -d --build

# Пересобрать конкретный сервис
docker-compose up -d --build auth-service
```

## Полезные команды

```bash
# Войти в контейнер
docker exec -it simplefood-auth-service bash

# Очистить кэш Laravel
docker exec -it simplefood-auth-service php artisan cache:clear

# Посмотреть статус контейнеров
docker-compose ps

# Удалить все контейнеры и volumes
docker-compose down -v
```
