#!/bin/bash

echo "============================================"
echo "Starting SimpleFood Microservices..."
echo "============================================"

cd "$(dirname "$0")/.."

echo ""
echo "[1/4] Starting Docker containers..."
docker-compose up -d

echo ""
echo "[2/4] Waiting for services to start (30 seconds)..."
sleep 30

echo ""
echo "[3/4] Running migrations..."
docker exec simplefood-auth-service php artisan migrate --force
docker exec simplefood-catalog-service php artisan migrate --force
docker exec simplefood-cart-service php artisan migrate --force
docker exec simplefood-order-service php artisan migrate --force
docker exec simplefood-payment-service php artisan migrate --force
docker exec simplefood-admin-service php artisan migrate --force

echo ""
echo "[4/4] Creating test data..."

# Auth Service - Create User
docker exec simplefood-auth-service php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\$user = new App\Models\User();
\$user->name = 'Admin';
\$user->email = 'admin@test.com';
\$user->password = bcrypt('password');
\$user->is_admin = 1;
\$user->save();
echo 'User created\n';
"

# Catalog Service - Create Categories
docker exec simplefood-catalog-service php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\$cat = new App\Models\Category();
\$cat->title = 'Pizza';
\$cat->slug = 'pizza';
\$cat->icon = 'pizza';
\$cat->save();
\$cat2 = new App\Models\Category();
\$cat2->title = 'Burgers';
\$cat2->slug = 'burgers';
\$cat2->icon = 'burger';
\$cat2->save();
echo 'Categories created\n';
"

# Catalog Service - Create Products
docker exec simplefood-catalog-service php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\$p = new App\Models\Product();
\$p->category_id = 1;
\$p->title = 'Margherita Pizza';
\$p->slug = 'margherita';
\$p->description = 'Classic Italian pizza';
\$p->price = 1200;
\$p->save();
\$p2 = new App\Models\Product();
\$p2->category_id = 2;
\$p2->title = 'Cheeseburger';
\$p2->slug = 'cheeseburger';
\$p2->description = 'Tasty burger with cheese';
\$p2->price = 800;
\$p2->save();
echo 'Products created\n';
"

# Cart Service - Create Cart Items
docker exec simplefood-cart-service php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\$cart = new App\Models\CartItem();
\$cart->user_id = 1;
\$cart->product_id = 1;
\$cart->quantity = 2;
\$cart->save();
\$cart2 = new App\Models\CartItem();
\$cart2->user_id = 1;
\$cart2->product_id = 2;
\$cart2->quantity = 1;
\$cart2->save();
echo 'Cart items created\n';
"

# Order Service - Create Order
docker exec simplefood-order-service php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\$user = new App\Models\User();
\$user->name = 'Test';
\$user->email = 'test@test.com';
\$user->password = 'fake';
\$user->save();
\$order = new App\Models\Order();
\$order->user_id = 1;
\$order->customer_name = 'Admin User';
\$order->phone = '+1234567890';
\$order->address = '123 Main St';
\$order->total_price = 3200;
\$order->status = 'completed';
\$order->payment_method = 'card';
\$order->payment_status = 'paid';
\$order->save();
\$orderId = App\Models\Order::first()->id;
\$item = new App\Models\OrderItem();
\$item->order_id = \$orderId;
\$item->product_id = 1;
\$item->product_title = 'Margherita Pizza';
\$item->unit_price = 1200;
\$item->quantity = 2;
\$item->line_total = 2400;
\$item->save();
echo 'Order created\n';
"

# Payment Service - Create Payment
docker exec simplefood-payment-service php -r "
require 'vendor/autoload.php';
\$app = require 'bootstrap/app.php';
\$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();
\$payment = new App\Models\Payment();
\$payment->order_id = 1;
\$payment->user_id = 1;
\$payment->amount = 3200;
\$payment->status = 'completed';
\$payment->payment_method = 'card';
\$payment->save();
echo 'Payment created\n';
"

echo ""
echo "============================================"
echo "All services started successfully!"
echo "============================================"
echo ""
echo "Available endpoints:"
echo "- API Gateway:     http://localhost:9000"
echo "- Auth Service:    http://localhost:8001/api/users"
echo "- Catalog Service: http://localhost:8002/api/products"
echo "- Cart Service:    http://localhost:8003/api/cart"
echo "- Order Service:   http://localhost:8000/api/orders"
echo "- Payment Service: http://localhost:8004/api/payments"
echo "- Admin Dashboard: http://localhost:8005/api/dashboard"
echo ""
echo "Credentials: admin@test.com / password"
echo ""
