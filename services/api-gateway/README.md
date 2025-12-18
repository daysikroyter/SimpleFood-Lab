# API Gateway

API Gateway для маршрутизации запросов между микросервисами SimpleFood.

## Порт
- **9000**

## Маршрутизация

### Auth Service (8001)
- `/api/auth/*` → http://auth-service:8001

### Catalog Service (8002)
- `/api/catalog/*` → http://catalog-service:8002
- `/api/products/*` → http://catalog-service:8002
- `/api/categories/*` → http://catalog-service:8002

### Cart Service (8003)
- `/api/cart/*` → http://cart-service:8003

### Order Service (8000)
- `/api/orders/*` → http://order-service:8000

### Payment Service (8004)
- `/api/payments/*` → http://payment-service:8004

### Admin Service (8005)
- `/api/admin/*` → http://admin-service:8005

## Возможности
- Rate limiting
- JWT проверка
- Логирование запросов
- CORS
- Request/Response трансформация
