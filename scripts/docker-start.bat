@echo off
echo ============================================
echo Starting SimpleFood Microservices...
echo ============================================

cd /d %~dp0..

echo.
echo [1/4] Starting Docker containers...
docker-compose up -d

echo.
echo [2/4] Waiting for services to start (30 seconds)...
timeout /t 30 /nobreak

echo.
echo [3/4] Running migrations...
docker exec simplefood-auth-service php artisan migrate --force
docker exec simplefood-catalog-service php artisan migrate --force
docker exec simplefood-cart-service php artisan migrate --force
docker exec simplefood-order-service php artisan migrate --force
docker exec simplefood-payment-service php artisan migrate --force
docker exec simplefood-admin-service php artisan migrate --force

echo.
echo [4/4] Creating test data...
docker exec simplefood-auth-service php -r "require 'vendor/autoload.php'; $app = require 'bootstrap/app.php'; $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); App\Models\User::updateOrCreate(['email' => 'admin@test.com'], ['name' => 'Admin', 'password' => bcrypt('password'), 'is_admin' => 1]); echo 'User created/updated\n';"

docker exec simplefood-catalog-service php -r "require 'vendor/autoload.php'; $app = require 'bootstrap/app.php'; $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); App\Models\Category::updateOrCreate(['slug' => 'pizza'], ['title' => 'Pizza', 'icon' => 'pizza']); App\Models\Category::updateOrCreate(['slug' => 'burgers'], ['title' => 'Burgers', 'icon' => 'burger']); echo 'Categories created/updated\n';"

docker exec simplefood-catalog-service php -r "require 'vendor/autoload.php'; $app = require 'bootstrap/app.php'; $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); App\Models\Product::updateOrCreate(['slug' => 'margherita'], ['category_id' => 1, 'title' => 'Margherita Pizza', 'description' => 'Classic Italian pizza', 'price' => 1200]); App\Models\Product::updateOrCreate(['slug' => 'cheeseburger'], ['category_id' => 2, 'title' => 'Cheeseburger', 'description' => 'Tasty burger with cheese', 'price' => 800]); echo 'Products created/updated\n';"

docker exec simplefood-cart-service php -r "require 'vendor/autoload.php'; $app = require 'bootstrap/app.php'; $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); App\Models\CartItem::updateOrCreate(['user_id' => 1, 'product_id' => 1], ['quantity' => 2]); App\Models\CartItem::updateOrCreate(['user_id' => 1, 'product_id' => 2], ['quantity' => 1]); echo 'Cart items created/updated\n';"

docker exec simplefood-order-service php -r "require 'vendor/autoload.php'; $app = require 'bootstrap/app.php'; $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); App\Models\User::updateOrCreate(['email' => 'test@test.com'], ['name' => 'Test', 'password' => 'fake']); $order = App\Models\Order::updateOrCreate(['customer_name' => 'Admin User', 'phone' => '+1234567890'], ['user_id' => 1, 'address' => '123 Main St', 'total_price' => 3200, 'status' => 'completed', 'payment_method' => 'card', 'payment_status' => 'paid']); App\Models\OrderItem::updateOrCreate(['order_id' => $order->id, 'product_id' => 1], ['product_title' => 'Margherita Pizza', 'unit_price' => 1200, 'quantity' => 2, 'line_total' => 2400]); echo 'Order ID: ' . $order->id . '\n';"

docker exec simplefood-payment-service php -r "require 'vendor/autoload.php'; $app = require 'bootstrap/app.php'; $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap(); App\Models\Payment::updateOrCreate(['user_id' => 1, 'amount' => 3200], ['order_id' => 1, 'status' => 'completed', 'payment_method' => 'card']); echo 'Payment created/updated\n';"

echo.
echo ============================================
echo All services started successfully!
echo ============================================
echo.
echo Available endpoints:
echo - API Gateway:     http://localhost:9000
echo - Auth Service:    http://localhost:8001/api/users
echo - Catalog Service: http://localhost:8002/api/products
echo - Cart Service:    http://localhost:8003/api/cart
echo - Order Service:   http://localhost:8000/api/orders
echo - Payment Service: http://localhost:8004/api/payments
echo - Admin Dashboard: http://localhost:8005/api/dashboard
echo.
echo Credentials: admin@test.com / password
echo.
pause
