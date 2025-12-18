#!/bin/bash

echo "🚀 Быстрый старт всех микросервисов SimpleFood"
echo "=============================================="

cd "$(dirname "$0")/.."

# 1. Запуск Docker
echo ""
echo "📦 1. Запуск Docker контейнеров..."
docker-compose up -d

echo "⏳ Ожидание запуска БД..."
sleep 10

# 2. Установка зависимостей
echo ""
echo "📚 2. Установка Composer зависимостей..."
services=("auth-service" "catalog-service" "cart-service" "order-service" "payment-service" "admin-service" "api-gateway")

for service in "${services[@]}"; do
    echo "   ➤ $service"
    docker exec simplefood-$service composer install --no-interaction 2>/dev/null || true
    docker exec simplefood-$service php artisan key:generate --force 2>/dev/null || true
done

# 3. Создание .env файлов
echo ""
echo "⚙️  3. Создание .env файлов..."
for service in "${services[@]}"; do
    if [ ! -f "services/$service/.env" ]; then
        echo "   ➤ $service"
        docker exec simplefood-$service cp .env.example .env 2>/dev/null || true
    fi
done

# 4. Миграции
echo ""
echo "🗄️  4. Выполнение миграций БД..."
docker exec simplefood-auth-service php artisan migrate --force 2>/dev/null || echo "   ⚠️  Auth миграции не выполнены"
docker exec simplefood-catalog-service php artisan migrate --force 2>/dev/null || echo "   ⚠️  Catalog миграции не выполнены"
docker exec simplefood-cart-service php artisan migrate --force 2>/dev/null || echo "   ⚠️  Cart миграции не выполнены"
docker exec simplefood-order-service php artisan migrate --force 2>/dev/null || echo "   ⚠️  Order миграции не выполнены"
docker exec simplefood-payment-service php artisan migrate --force 2>/dev/null || echo "   ⚠️  Payment миграции не выполнены"

# 5. Проверка статуса
echo ""
echo "📊 5. Статус сервисов:"
docker-compose ps

echo ""
echo "✅ Готово!"
echo ""
echo "🌐 Доступные endpoints:"
echo "   API Gateway:     http://localhost:9000"
echo "   Auth Service:    http://localhost:8001"
echo "   Catalog Service: http://localhost:8002"
echo "   Cart Service:    http://localhost:8003"
echo "   Order Service:   http://localhost:8000"
echo "   Payment Service: http://localhost:8004"
echo "   Admin Service:   http://localhost:8005"
echo "   RabbitMQ UI:     http://localhost:15672 (admin/admin)"
echo ""
echo "🧪 Проверка здоровья:"
echo "   curl http://localhost:9000/health"
echo ""
