#!/bin/bash

echo "🔄 Миграция моделей и миграций из монолита в микросервисы..."

# Создание директорий если не существуют
create_dirs() {
    local service=$1
    mkdir -p services/$service/app/Models
    mkdir -p services/$service/database/migrations
    mkdir -p services/$service/app/Http/Controllers
}

# Auth Service
echo "📦 Auth Service - копирование моделей и миграций..."
create_dirs "auth-service"

# Модели
cp app/Models/User.php services/auth-service/app/Models/ 2>/dev/null || echo "⚠️  User.php не найден"

# Миграции
cp database/migrations/0001_01_01_000000_create_users_table.php services/auth-service/database/migrations/ 2>/dev/null
cp database/migrations/2025_12_11_165052_add_is_admin_to_users_table.php services/auth-service/database/migrations/ 2>/dev/null

echo "✅ Auth Service готов"

# Catalog Service
echo "📦 Catalog Service - копирование моделей и миграций..."
create_dirs "catalog-service"

# Модели
cp app/Models/Category.php services/catalog-service/app/Models/ 2>/dev/null || echo "⚠️  Category.php не найден"
cp app/Models/Product.php services/catalog-service/app/Models/ 2>/dev/null || echo "⚠️  Product.php не найден"
cp app/Models/ProductReview.php services/catalog-service/app/Models/ 2>/dev/null || echo "⚠️  ProductReview.php не найден"

# Миграции
cp database/migrations/2025_12_11_182523_create_categories_table.php services/catalog-service/database/migrations/ 2>/dev/null
cp database/migrations/2025_12_11_192301_create_products_table.php services/catalog-service/database/migrations/ 2>/dev/null
cp database/migrations/2025_12_11_194339_change_price_type_in_products_table.php services/catalog-service/database/migrations/ 2>/dev/null
cp database/migrations/2025_12_11_204339_create_product_reviews_table.php services/catalog-service/database/migrations/ 2>/dev/null

# Контроллеры
cp app/Http/Controllers/ProductController.php services/catalog-service/app/Http/Controllers/ 2>/dev/null || echo "⚠️  ProductController.php не найден"
cp app/Http/Controllers/CategoryController.php services/catalog-service/app/Http/Controllers/ 2>/dev/null || echo "⚠️  CategoryController.php не найден"

echo "✅ Catalog Service готов"

# Cart Service
echo "📦 Cart Service - копирование моделей и миграций..."
create_dirs "cart-service"

# Модели
cp app/Models/CartItem.php services/cart-service/app/Models/ 2>/dev/null || echo "⚠️  CartItem.php не найден"

# Миграции
cp database/migrations/2025_12_11_224815_create_cart_items_table.php services/cart-service/database/migrations/ 2>/dev/null

# Контроллеры
cp app/Http/Controllers/CartController.php services/cart-service/app/Http/Controllers/ 2>/dev/null || echo "⚠️  CartController.php не найден"

echo "✅ Cart Service готов"

# Order Service
echo "📦 Order Service - копирование моделей и миграций..."
create_dirs "order-service"

# Модели
cp app/Models/Order.php services/order-service/app/Models/ 2>/dev/null || echo "⚠️  Order.php не найден"
cp app/Models/OrderItem.php services/order-service/app/Models/ 2>/dev/null || echo "⚠️  OrderItem.php не найден"

# Миграции
cp database/migrations/2025_12_11_232601_create_orders_table.php services/order-service/database/migrations/ 2>/dev/null
cp database/migrations/2025_12_11_232629_create_order_items_table.php services/order-service/database/migrations/ 2>/dev/null
cp database/migrations/2025_12_11_234100_adjust_orders_table.php services/order-service/database/migrations/ 2>/dev/null
cp database/migrations/2025_12_11_234135_adjust_order_items_table.php services/order-service/database/migrations/ 2>/dev/null
cp database/migrations/2025_12_11_235704_drop_price_from_order_items_table.php services/order-service/database/migrations/ 2>/dev/null

# Контроллеры
cp app/Http/Controllers/OrderController.php services/order-service/app/Http/Controllers/ 2>/dev/null || echo "⚠️  OrderController.php не найден"

echo "✅ Order Service готов"

# Payment Service
echo "📦 Payment Service - создание базовой структуры..."
create_dirs "payment-service"
echo "⚠️  Payment Service требует создания новых моделей"

# Admin Service
echo "📦 Admin Service - создание базовой структуры..."
create_dirs "admin-service"
echo "⚠️  Admin Service требует создания новых моделей"

echo ""
echo "✅ Миграция завершена!"
echo ""
echo "📋 Следующие шаги:"
echo "1. Проверьте скопированные файлы в каждом сервисе"
echo "2. Обновите namespace в моделях и контроллерах"
echo "3. Создайте недостающие модели для Payment и Admin сервисов"
echo "4. Обновите routes в каждом сервисе"
echo "5. Запустите миграции: make migrate"
echo ""
