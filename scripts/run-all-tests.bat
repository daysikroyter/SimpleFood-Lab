@echo off
echo 🧪 Running tests for all microservices...

set services=auth-service catalog-service cart-service order-service payment-service admin-service

for %%s in (%services%) do (
    echo.
    echo 📦 Testing %%s...
    cd services\%%s
    
    if exist vendor\bin\phpunit.bat (
        call composer test
        if errorlevel 1 (
            echo ❌ %%s tests failed
            exit /b 1
        ) else (
            echo ✅ %%s tests passed
        )
    ) else (
        echo ⚠️  PHPUnit not installed in %%s, running composer install...
        call composer install
        call composer test
    )
    
    cd ..\..
)

echo.
echo ✅ All tests completed successfully!
