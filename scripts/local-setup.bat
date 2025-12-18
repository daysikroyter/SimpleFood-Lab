@echo off
chcp 65001 > nul
echo ========================================
echo   Локальная настройка микросервисов
echo ========================================

cd /d %~dp0..

:: Создание .env файлов
echo.
echo [1/3] Создание .env файлов...

for %%s in (auth-service catalog-service cart-service order-service payment-service admin-service api-gateway) do (
    echo Настройка %%s...
    if not exist services\%%s\.env (
        copy services\%%s\.env.example services\%%s\.env >nul 2>&1
    )
    cd services\%%s
    php artisan key:generate --force >nul 2>&1
    cd ..\..
)

echo.
echo [2/3] Создание баз данных в MySQL...
echo.
echo Выполните эти SQL команды в MySQL (HeidiSQL в Laragon):
echo.
echo CREATE DATABASE IF NOT EXISTS auth_db;
echo CREATE DATABASE IF NOT EXISTS catalog_db;
echo CREATE DATABASE IF NOT EXISTS cart_db;
echo CREATE DATABASE IF NOT EXISTS orders_db;
echo CREATE DATABASE IF NOT EXISTS payments_db;
echo CREATE DATABASE IF NOT EXISTS admin_db;
echo.
pause

echo.
echo [3/3] Запуск миграций...
echo.

for %%s in (auth-service catalog-service cart-service order-service payment-service admin-service) do (
    echo Миграции для %%s...
    cd services\%%s
    php artisan migrate --force
    cd ..\..
)

echo.
echo ========================================
echo   Настройка завершена!
echo ========================================
echo.
echo Теперь запустите: scripts\local-start.bat
pause
