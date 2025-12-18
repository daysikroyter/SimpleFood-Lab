<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimpleFood - Админ панель</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 40px rgba(0,0,0,0.12);
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">
    <!-- Header -->
    <nav class="gradient-bg shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-white text-2xl font-bold">🍔 SimpleFood</span>
                    <span class="ml-4 text-white/80 text-sm">Админ панель</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white/80 text-sm">Добро пожаловать, Администратор</span>
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <span class="text-white">👤</span>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Users -->
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Пользователи</p>
                        <p class="text-3xl font-bold text-gray-800" id="users-count">{{ $stats['users'] ?? 0 }}</p>
                        <p class="text-green-500 text-sm mt-1">+12% за месяц</p>
                    </div>
                    <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">👥</span>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Товары</p>
                        <p class="text-3xl font-bold text-gray-800" id="products-count">{{ $stats['products'] ?? 0 }}</p>
                        <p class="text-green-500 text-sm mt-1">+5 новых</p>
                    </div>
                    <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">🍕</span>
                    </div>
                </div>
            </div>

            <!-- Orders -->
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Заказы</p>
                        <p class="text-3xl font-bold text-gray-800" id="orders-count">{{ $stats['orders'] ?? 0 }}</p>
                        <p class="text-green-500 text-sm mt-1">+28% за неделю</p>
                    </div>
                    <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="bg-white rounded-xl shadow-md p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm font-medium">Доход</p>
                        <p class="text-3xl font-bold text-gray-800" id="revenue">{{ number_format($stats['revenue'] ?? 0, 0, ',', ' ') }} ₽</p>
                        <p class="text-green-500 text-sm mt-1">+18% за месяц</p>
                    </div>
                    <div class="w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center">
                        <span class="text-2xl">💰</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Chart -->
            <div class="lg:col-span-2 bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📊 Статистика заказов</h3>
                <canvas id="ordersChart" height="100"></canvas>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🕐 Последние заказы</h3>
                <div class="space-y-4">
                    @forelse($recentOrders ?? [] as $order)
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">#{{ $order['id'] ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">{{ $order['customer'] ?? 'Клиент' }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-800">{{ $order['total'] ?? 0 }} ₽</p>
                            <span class="text-xs px-2 py-1 rounded-full {{ $order['status'] === 'completed' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                                {{ $order['status'] === 'completed' ? 'Выполнен' : 'В процессе' }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">#1001</p>
                            <p class="text-sm text-gray-500">Иван Петров</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-800">1,250 ₽</p>
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">Выполнен</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">#1002</p>
                            <p class="text-sm text-gray-500">Мария Сидорова</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-800">890 ₽</p>
                            <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-600">В процессе</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div>
                            <p class="font-medium text-gray-800">#1003</p>
                            <p class="text-sm text-gray-500">Алексей Козлов</p>
                        </div>
                        <div class="text-right">
                            <p class="font-medium text-gray-800">2,340 ₽</p>
                            <span class="text-xs px-2 py-1 rounded-full bg-green-100 text-green-600">Выполнен</span>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Services Status -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🔌 Статус микросервисов</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <div class="p-4 bg-gray-50 rounded-lg text-center" id="auth-status">
                    <div class="w-3 h-3 rounded-full bg-green-500 mx-auto mb-2 animate-pulse"></div>
                    <p class="font-medium text-gray-800">Auth</p>
                    <p class="text-xs text-gray-500">:8001</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center" id="catalog-status">
                    <div class="w-3 h-3 rounded-full bg-green-500 mx-auto mb-2 animate-pulse"></div>
                    <p class="font-medium text-gray-800">Catalog</p>
                    <p class="text-xs text-gray-500">:8002</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center" id="cart-status">
                    <div class="w-3 h-3 rounded-full bg-green-500 mx-auto mb-2 animate-pulse"></div>
                    <p class="font-medium text-gray-800">Cart</p>
                    <p class="text-xs text-gray-500">:8003</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center" id="order-status">
                    <div class="w-3 h-3 rounded-full bg-green-500 mx-auto mb-2 animate-pulse"></div>
                    <p class="font-medium text-gray-800">Order</p>
                    <p class="text-xs text-gray-500">:8004</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center" id="admin-status">
                    <div class="w-3 h-3 rounded-full bg-green-500 mx-auto mb-2 animate-pulse"></div>
                    <p class="font-medium text-gray-800">Admin</p>
                    <p class="text-xs text-gray-500">:8005</p>
                </div>
                <div class="p-4 bg-gray-50 rounded-lg text-center" id="payment-status">
                    <div class="w-3 h-3 rounded-full bg-green-500 mx-auto mb-2 animate-pulse"></div>
                    <p class="font-medium text-gray-800">Payment</p>
                    <p class="text-xs text-gray-500">:8006</p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="/api/users" class="block p-4 bg-blue-500 hover:bg-blue-600 text-white rounded-xl text-center transition card-hover">
                <span class="text-2xl">👥</span>
                <p class="mt-2 font-medium">Управление пользователями</p>
            </a>
            <a href="/api/products" class="block p-4 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-center transition card-hover">
                <span class="text-2xl">🍔</span>
                <p class="mt-2 font-medium">Управление товарами</p>
            </a>
            <a href="/api/orders" class="block p-4 bg-green-500 hover:bg-green-600 text-white rounded-xl text-center transition card-hover">
                <span class="text-2xl">📦</span>
                <p class="mt-2 font-medium">Управление заказами</p>
            </a>
            <a href="/api/analytics" class="block p-4 bg-purple-500 hover:bg-purple-600 text-white rounded-xl text-center transition card-hover">
                <span class="text-2xl">📊</span>
                <p class="mt-2 font-medium">Аналитика</p>
            </a>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-6 mt-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-gray-400">© 2025 SimpleFood - Микросервисная архитектура</p>
            <p class="text-gray-500 text-sm mt-1">Auth • Catalog • Cart • Order • Payment • Admin</p>
        </div>
    </footer>

    <script>
        // Orders Chart
        const ctx = document.getElementById('ordersChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс'],
                datasets: [{
                    label: 'Заказы',
                    data: [12, 19, 15, 25, 22, 30, 28],
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Доход (тыс. ₽)',
                    data: [8, 15, 12, 20, 18, 25, 22],
                    borderColor: 'rgb(118, 75, 162)',
                    backgroundColor: 'rgba(118, 75, 162, 0.1)',
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Check services status
        const services = [
            { name: 'auth', port: 8001 },
            { name: 'catalog', port: 8002 },
            { name: 'cart', port: 8003 },
            { name: 'order', port: 8004 },
            { name: 'admin', port: 8005 },
            { name: 'payment', port: 8006 }
        ];

        // Auto-refresh dashboard data
        async function refreshDashboard() {
            try {
                const response = await fetch('/api/dashboard');
                const data = await response.json();
                if (data.success) {
                    document.getElementById('users-count').textContent = data.data.stats.total_users || 0;
                    document.getElementById('products-count').textContent = data.data.stats.total_products || 0;
                    document.getElementById('orders-count').textContent = data.data.stats.total_orders || 0;
                    document.getElementById('revenue').textContent = new Intl.NumberFormat('ru-RU').format(data.data.stats.total_revenue || 0) + ' ₽';
                }
            } catch (e) {
                console.log('Dashboard refresh error:', e);
            }
        }

        // Refresh every 30 seconds
        setInterval(refreshDashboard, 30000);
        refreshDashboard();
    </script>
</body>
</html>
