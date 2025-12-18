@echo off
echo 🚀 Быстрый старт всех микросервисов SimpleFood
echo ==============================================

cd /d "%~dp0\.."

REM 1. Запуск Docker
echo.
echo 📦 1. Запуск Docker контейнеров...
docker-compose up -d

echo ⏳ Ожидание запуска БД...
timeout /t 10 /nobreak >nul

REM 2. Установка зависимостей
echo.
echo 📚 2. Установка Composer зависимостей...
for %%s in (auth-service catalog-service cart-service order-service payment-service admin-service api-gateway) do (
    echo    ➤ %%s
    docker exec simplefood-%%s composer install --no-interaction >nul 2>&1
    docker exec simplefood-%%s php artisan key:generate --force >nul 2>&1
)

REM 3. Создание .env файлов
echo.
echo ⚙️  3. Создание .env файлов...
for %%s in (auth-service catalog-service cart-service order-service payment-service admin-service api-gateway) do (
    if not exist "services\%%s\.env" (
        echo    ➤ %%s
        docker exec simplefood-%%s cp .env.example .env >nul 2>&1
    )
)

REM 4. Миграции
echo.
echo 🗄️  4. Выполнение миграций БД...
docker exec simplefood-auth-service php artisan migrate --force >nul 2>&1 || echo    ⚠️  Auth миграции не выполнены
docker exec simplefood-catalog-service php artisan migrate --force >nul 2>&1 || echo    ⚠️  Catalog миграции не выполнены
docker exec simplefood-cart-service php artisan migrate --force >nul 2>&1 || echo    ⚠️  Cart миграции не выполнены
docker exec simplefood-order-service php artisan migrate --force >nul 2>&1 || echo    ⚠️  Order миграции не выполнены
docker exec simplefood-payment-service php artisan migrate --force >nul 2>&1 || echo    ⚠️  Payment миграции не выполнены

REM 5. Проверка статуса
echo.
echo 📊 5. Статус сервисов:
docker-compose ps

echo.
echo ✅ Готово!
echo.
echo 🌐 Доступные endpoints:
echo    API Gateway:     http://localhost:9000
echo    Auth Service:    http://localhost:8001
echo    Catalog Service: http://localhost:8002
echo    Cart Service:    http://localhost:8003
echo    Order Service:   http://localhost:8000
echo    Payment Service: http://localhost:8004
echo    Admin Service:   http://localhost:8005
echo    RabbitMQ UI:     http://localhost:15672 (admin/admin)
echo.
echo 🧪 Проверка здоровья:
echo    curl http://localhost:9000/health
echo.
pause
