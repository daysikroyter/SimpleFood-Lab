@echo off
echo 🔄 Миграция моделей и миграций из монолита в микросервисы...

REM Auth Service
echo 📦 Auth Service - копирование моделей и миграций...
if not exist "services\auth-service\app\Models" mkdir "services\auth-service\app\Models"
if not exist "services\auth-service\database\migrations" mkdir "services\auth-service\database\migrations"
if not exist "services\auth-service\app\Http\Controllers" mkdir "services\auth-service\app\Http\Controllers"

copy "app\Models\User.php" "services\auth-service\app\Models\" >nul 2>&1
copy "database\migrations\0001_01_01_000000_create_users_table.php" "services\auth-service\database\migrations\" >nul 2>&1
copy "database\migrations\2025_12_11_165052_add_is_admin_to_users_table.php" "services\auth-service\database\migrations\" >nul 2>&1

echo ✅ Auth Service готов

REM Catalog Service
echo 📦 Catalog Service - копирование моделей и миграций...
if not exist "services\catalog-service\app\Models" mkdir "services\catalog-service\app\Models"
if not exist "services\catalog-service\database\migrations" mkdir "services\catalog-service\database\migrations"
if not exist "services\catalog-service\app\Http\Controllers" mkdir "services\catalog-service\app\Http\Controllers"

copy "app\Models\Category.php" "services\catalog-service\app\Models\" >nul 2>&1
copy "app\Models\Product.php" "services\catalog-service\app\Models\" >nul 2>&1
copy "app\Models\ProductReview.php" "services\catalog-service\app\Models\" >nul 2>&1

copy "database\migrations\2025_12_11_182523_create_categories_table.php" "services\catalog-service\database\migrations\" >nul 2>&1
copy "database\migrations\2025_12_11_192301_create_products_table.php" "services\catalog-service\database\migrations\" >nul 2>&1
copy "database\migrations\2025_12_11_194339_change_price_type_in_products_table.php" "services\catalog-service\database\migrations\" >nul 2>&1
copy "database\migrations\2025_12_11_204339_create_product_reviews_table.php" "services\catalog-service\database\migrations\" >nul 2>&1

copy "app\Http\Controllers\ProductController.php" "services\catalog-service\app\Http\Controllers\" >nul 2>&1
copy "app\Http\Controllers\CategoryController.php" "services\catalog-service\app\Http\Controllers\" >nul 2>&1

echo ✅ Catalog Service готов

REM Cart Service
echo 📦 Cart Service - копирование моделей и миграций...
if not exist "services\cart-service\app\Models" mkdir "services\cart-service\app\Models"
if not exist "services\cart-service\database\migrations" mkdir "services\cart-service\database\migrations"
if not exist "services\cart-service\app\Http\Controllers" mkdir "services\cart-service\app\Http\Controllers"

copy "app\Models\CartItem.php" "services\cart-service\app\Models\" >nul 2>&1
copy "database\migrations\2025_12_11_224815_create_cart_items_table.php" "services\cart-service\database\migrations\" >nul 2>&1
copy "app\Http\Controllers\CartController.php" "services\cart-service\app\Http\Controllers\" >nul 2>&1

echo ✅ Cart Service готов

REM Order Service
echo 📦 Order Service - копирование моделей и миграций...
if not exist "services\order-service\app\Models" mkdir "services\order-service\app\Models"
if not exist "services\order-service\database\migrations" mkdir "services\order-service\database\migrations"
if not exist "services\order-service\app\Http\Controllers" mkdir "services\order-service\app\Http\Controllers"

copy "app\Models\Order.php" "services\order-service\app\Models\" >nul 2>&1
copy "app\Models\OrderItem.php" "services\order-service\app\Models\" >nul 2>&1

copy "database\migrations\2025_12_11_232601_create_orders_table.php" "services\order-service\database\migrations\" >nul 2>&1
copy "database\migrations\2025_12_11_232629_create_order_items_table.php" "services\order-service\database\migrations\" >nul 2>&1
copy "database\migrations\2025_12_11_234100_adjust_orders_table.php" "services\order-service\database\migrations\" >nul 2>&1
copy "database\migrations\2025_12_11_234135_adjust_order_items_table.php" "services\order-service\database\migrations\" >nul 2>&1
copy "database\migrations\2025_12_11_235704_drop_price_from_order_items_table.php" "services\order-service\database\migrations\" >nul 2>&1

copy "app\Http\Controllers\OrderController.php" "services\order-service\app\Http\Controllers\" >nul 2>&1

echo ✅ Order Service готов

REM Payment Service
echo 📦 Payment Service - создание базовой структуры...
if not exist "services\payment-service\app\Models" mkdir "services\payment-service\app\Models"
if not exist "services\payment-service\database\migrations" mkdir "services\payment-service\database\migrations"
if not exist "services\payment-service\app\Http\Controllers" mkdir "services\payment-service\app\Http\Controllers"
echo ⚠️  Payment Service требует создания новых моделей

REM Admin Service
echo 📦 Admin Service - создание базовой структуры...
if not exist "services\admin-service\app\Models" mkdir "services\admin-service\app\Models"
if not exist "services\admin-service\database\migrations" mkdir "services\admin-service\database\migrations"
if not exist "services\admin-service\app\Http\Controllers" mkdir "services\admin-service\app\Http\Controllers"
echo ⚠️  Admin Service требует создания новых моделей

echo.
echo ✅ Миграция завершена!
echo.
echo 📋 Следующие шаги:
echo 1. Проверьте скопированные файлы в каждом сервисе
echo 2. Обновите namespace в моделях и контроллерах
echo 3. Создайте недостающие модели для Payment и Admin сервисов
echo 4. Обновите routes в каждом сервисе
echo 5. Запустите миграции: make migrate
echo.
pause
