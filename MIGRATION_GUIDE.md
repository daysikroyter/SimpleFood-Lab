# Руководство по миграции из монолита в микросервисы

## 📦 Распределение моделей по сервисам

### Auth Service
Модели:
- `User` (из app/Models/User.php)

Миграции:
- `0001_01_01_000000_create_users_table.php`
- `2025_12_11_165052_add_is_admin_to_users_table.php`

### Catalog Service
Модели:
- `Category` (из app/Models/Category.php)
- `Product` (из app/Models/Product.php)
- `ProductReview` (из app/Models/ProductReview.php)

Миграции:
- `2025_12_11_182523_create_categories_table.php`
- `2025_12_11_192301_create_products_table.php`
- `2025_12_11_194339_change_price_type_in_products_table.php`
- `2025_12_11_204339_create_product_reviews_table.php`

### Cart Service
Модели:
- `CartItem` (из app/Models/CartItem.php)

Миграции:
- `2025_12_11_224815_create_cart_items_table.php`

### Order Service
Модели:
- `Order` (из app/Models/Order.php)
- `OrderItem` (из app/Models/OrderItem.php)

Миграции:
- `2025_12_11_232601_create_orders_table.php`
- `2025_12_11_232629_create_order_items_table.php`
- `2025_12_11_234100_adjust_orders_table.php`
- `2025_12_11_234135_adjust_order_items_table.php`
- `2025_12_11_235704_drop_price_from_order_items_table.php`

### Payment Service
Создать новые модели:
- `Payment`
- `Transaction`
- `Refund`

### Admin Service
Создать новые модели:
- `AdminLog`
- `SystemSetting`
- `Analytics`

## 🔄 Шаги миграции

### 1. Копирование моделей

```bash
# Auth Service
cp app/Models/User.php services/auth-service/app/Models/

# Catalog Service
cp app/Models/Category.php services/catalog-service/app/Models/
cp app/Models/Product.php services/catalog-service/app/Models/
cp app/Models/ProductReview.php services/catalog-service/app/Models/

# Cart Service
cp app/Models/CartItem.php services/cart-service/app/Models/

# Order Service (уже существует)
cp app/Models/Order.php services/order-service/app/Models/
cp app/Models/OrderItem.php services/order-service/app/Models/
```

### 2. Копирование миграций

```bash
# Auth Service
cp database/migrations/0001_01_01_000000_create_users_table.php services/auth-service/database/migrations/
cp database/migrations/2025_12_11_165052_add_is_admin_to_users_table.php services/auth-service/database/migrations/

# Catalog Service
cp database/migrations/2025_12_11_182523_create_categories_table.php services/catalog-service/database/migrations/
cp database/migrations/2025_12_11_192301_create_products_table.php services/catalog-service/database/migrations/
cp database/migrations/2025_12_11_194339_change_price_type_in_products_table.php services/catalog-service/database/migrations/
cp database/migrations/2025_12_11_204339_create_product_reviews_table.php services/catalog-service/database/migrations/

# Cart Service
cp database/migrations/2025_12_11_224815_create_cart_items_table.php services/cart-service/database/migrations/

# Order Service
cp database/migrations/2025_12_11_232601_create_orders_table.php services/order-service/database/migrations/
cp database/migrations/2025_12_11_232629_create_order_items_table.php services/order-service/database/migrations/
cp database/migrations/2025_12_11_234100_adjust_orders_table.php services/order-service/database/migrations/
cp database/migrations/2025_12_11_234135_adjust_order_items_table.php services/order-service/database/migrations/
cp database/migrations/2025_12_11_235704_drop_price_from_order_items_table.php services/order-service/database/migrations/
```

### 3. Обновление контроллеров

Распределите контроллеры из `app/Http/Controllers/` по соответствующим сервисам.

### 4. Миграция данных

```bash
# Экспорт данных из монолитной БД
mysqldump -u root -p simplefood users > users.sql
mysqldump -u root -p simplefood categories products product_reviews > catalog.sql
mysqldump -u root -p simplefood cart_items > cart.sql
mysqldump -u root -p simplefood orders order_items > orders.sql

# Импорт в микросервисы
mysql -u root -p auth_db < users.sql
mysql -u root -p catalog_db < catalog.sql
mysql -u root -p cart_db < cart.sql
mysql -u root -p orders_db < orders.sql
```

## 🔗 Обновление связей между сервисами

### Изменения в моделях

Вместо прямых связей через Eloquent, используйте HTTP запросы к другим сервисам:

**Было (монолит):**
```php
$order = Order::with('user', 'items.product')->find($id);
```

**Стало (микросервисы):**
```php
// В Order Service
$order = Order::with('items')->find($id);

// Получить данные пользователя из Auth Service
$user = Http::get("http://auth-service:8001/api/users/{$order->user_id}")->json();

// Получить данные продуктов из Catalog Service
foreach ($order->items as $item) {
    $product = Http::get("http://catalog-service:8002/api/products/{$item->product_id}")->json();
    $item->product = $product;
}
```

## 🎯 Рекомендации

1. **Постепенная миграция**: Начните с одного сервиса и протестируйте перед переходом к следующему
2. **Синхронизация данных**: Используйте RabbitMQ для событий между сервисами
3. **Кеширование**: Используйте Redis для кеширования часто запрашиваемых данных
4. **Транзакции**: Реализуйте паттерн Saga для распределенных транзакций
5. **Мониторинг**: Настройте логирование и мониторинг всех сервисов

## 📝 Checklist миграции

- [ ] Скопированы модели
- [ ] Скопированы миграции
- [ ] Обновлены контроллеры
- [ ] Созданы API endpoints
- [ ] Обновлены связи между моделями
- [ ] Настроена коммуникация между сервисами
- [ ] Мигрированы данные
- [ ] Написаны тесты
- [ ] Обновлена документация
- [ ] Протестирована работа всей системы
