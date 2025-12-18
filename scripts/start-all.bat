@echo off
echo 🚀 Starting all microservices...

REM Проверка Docker
where docker >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ Docker не установлен!
    exit /b 1
)

where docker-compose >nul 2>nul
if %errorlevel% neq 0 (
    echo ❌ Docker Compose не установлен!
    exit /b 1
)

REM Остановка существующих контейнеров
echo 🛑 Stopping existing containers...
docker-compose down

REM Сборка образов
echo 🔨 Building Docker images...
docker-compose build

REM Запуск сервисов
echo 🚀 Starting services...
docker-compose up -d

REM Ожидание запуска
echo ⏳ Waiting for services to start...
timeout /t 10 /nobreak >nul

REM Проверка статуса
echo 📊 Checking services status...
docker-compose ps

echo.
echo ✅ All services are running!
echo.
echo 📌 Available endpoints:
echo    API Gateway: http://localhost:9000
echo    Auth Service: http://localhost:8001
echo    Catalog Service: http://localhost:8002
echo    Cart Service: http://localhost:8003
echo    Order Service: http://localhost:8000
echo    Payment Service: http://localhost:8004
echo    Admin Service: http://localhost:8005
echo    RabbitMQ Management: http://localhost:15672 (admin/admin)
