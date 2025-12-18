#!/bin/bash

echo "🧪 Running tests for all microservices..."

services=("auth-service" "catalog-service" "cart-service" "order-service" "payment-service" "admin-service")

for service in "${services[@]}"
do
    echo ""
    echo "📦 Testing $service..."
    cd services/$service
    
    if [ -f "vendor/bin/phpunit" ]; then
        composer test
        if [ $? -eq 0 ]; then
            echo "✅ $service tests passed"
        else
            echo "❌ $service tests failed"
            exit 1
        fi
    else
        echo "⚠️  PHPUnit not installed in $service, running composer install..."
        composer install
        composer test
    fi
    
    cd ../..
done

echo ""
echo "✅ All tests completed successfully!"
