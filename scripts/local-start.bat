@echo off
chcp 65001 > nul
echo ========================================
echo   Запуск микросервисов локально
echo ========================================
echo.
echo Запускаю сервисы на портах:
echo - API Gateway:     http://localhost:9000
echo - Auth Service:    http://localhost:8001
echo - Catalog Service: http://localhost:8002
echo - Cart Service:    http://localhost:8003
echo - Order Service:   http://localhost:8000
echo - Payment Service: http://localhost:8004
echo - Admin Service:   http://localhost:8005
echo.
echo Для остановки нажмите Ctrl+C в каждом окне
echo.
pause

cd /d %~dp0..

:: Запуск каждого сервиса в отдельном окне
start "Auth Service" cmd /k "cd services\auth-service && php artisan serve --port=8001"
timeout /t 2 /nobreak >nul

start "Catalog Service" cmd /k "cd services\catalog-service && php artisan serve --port=8002"
timeout /t 2 /nobreak >nul

start "Cart Service" cmd /k "cd services\cart-service && php artisan serve --port=8003"
timeout /t 2 /nobreak >nul

start "Order Service" cmd /k "cd services\order-service && php artisan serve --port=8000"
timeout /t 2 /nobreak >nul

start "Payment Service" cmd /k "cd services\payment-service && php artisan serve --port=8004"
timeout /t 2 /nobreak >nul

start "Admin Service" cmd /k "cd services\admin-service && php artisan serve --port=8005"
timeout /t 2 /nobreak >nul

start "API Gateway" cmd /k "cd services\api-gateway && php artisan serve --port=9000"

echo.
echo Все сервисы запущены!
echo.
