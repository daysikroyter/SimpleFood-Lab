#!/bin/bash

echo "🚀 Starting all microservices..."

# Проверка Docker
if ! command -v docker &> /dev/null; then
    echo "❌ Docker не установлен!"
    exit 1
fi

if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose не установлен!"
    exit 1
fi

# Остановка существующих контейнеров
echo "🛑 Stopping existing containers..."
docker-compose down

# Сборка образов
echo "🔨 Building Docker images..."
docker-compose build

# Запуск сервисов
echo "🚀 Starting services..."
docker-compose up -d

# Ожидание запуска
echo "⏳ Waiting for services to start..."
sleep 10

# Проверка статуса
echo "📊 Checking services status..."
docker-compose ps

echo ""
echo "✅ All services are running!"
echo ""
echo "📌 Available endpoints:"
echo "   API Gateway: http://localhost:9000"
echo "   Auth Service: http://localhost:8001"
echo "   Catalog Service: http://localhost:8002"
echo "   Cart Service: http://localhost:8003"
echo "   Order Service: http://localhost:8000"
echo "   Payment Service: http://localhost:8004"
echo "   Admin Service: http://localhost:8005"
echo "   RabbitMQ Management: http://localhost:15672 (admin/admin)"
