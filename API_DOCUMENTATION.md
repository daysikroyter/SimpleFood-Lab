# API Endpoints Documentation

## 🔐 Auth Service (port 8001)

### Authentication
```
POST   /api/register          - Регистрация нового пользователя
POST   /api/login             - Вход в систему
POST   /api/logout            - Выход из системы
POST   /api/refresh           - Обновление JWT токена
GET    /api/me                - Получить текущего пользователя
```

### Users
```
GET    /api/users             - Список пользователей (admin)
GET    /api/users/{id}        - Получить пользователя
PUT    /api/users/{id}        - Обновить пользователя
DELETE /api/users/{id}        - Удалить пользователя (admin)
```

---

## 📦 Catalog Service (port 8002)

### Categories
```
GET    /api/categories        - Список категорий
GET    /api/categories/{id}   - Получить категорию
POST   /api/categories        - Создать категорию (admin)
PUT    /api/categories/{id}   - Обновить категорию (admin)
DELETE /api/categories/{id}   - Удалить категорию (admin)
```

### Products
```
GET    /api/products          - Список продуктов
GET    /api/products/{id}     - Получить продукт
POST   /api/products          - Создать продукт (admin)
PUT    /api/products/{id}     - Обновить продукт (admin)
DELETE /api/products/{id}     - Удалить продукт (admin)
GET    /api/products/search   - Поиск продуктов
GET    /api/products/category/{id} - Продукты по категории
```

### Reviews
```
GET    /api/products/{id}/reviews     - Отзывы о продукте
POST   /api/products/{id}/reviews     - Добавить отзыв
PUT    /api/reviews/{id}              - Обновить отзыв
DELETE /api/reviews/{id}              - Удалить отзыв
```

---

## 🛒 Cart Service (port 8003)

### Cart
```
GET    /api/cart              - Получить корзину
POST   /api/cart/items        - Добавить товар в корзину
PUT    /api/cart/items/{id}   - Обновить количество
DELETE /api/cart/items/{id}   - Удалить товар из корзины
DELETE /api/cart/clear         - Очистить корзину
GET    /api/cart/total        - Получить общую стоимость
```

### Promo Codes
```
POST   /api/cart/promo        - Применить промокод
DELETE /api/cart/promo         - Удалить промокод
```

---

## 📋 Order Service (port 8000)

### Orders
```
GET    /api/orders            - Список заказов пользователя
GET    /api/orders/{id}       - Получить заказ
POST   /api/orders            - Создать заказ
PUT    /api/orders/{id}/status - Обновить статус (admin)
DELETE /api/orders/{id}        - Отменить заказ
```

### Order History
```
GET    /api/orders/history    - История заказов
GET    /api/orders/{id}/track - Отследить заказ
```

---

## 💳 Payment Service (port 8004)

### Payments
```
POST   /api/payments          - Создать платеж
GET    /api/payments/{id}     - Статус платежа
POST   /api/payments/{id}/confirm - Подтвердить платеж
POST   /api/payments/{id}/cancel  - Отменить платеж
```

### Transactions
```
GET    /api/transactions      - История транзакций
GET    /api/transactions/{id} - Детали транзакции
```

### Refunds
```
POST   /api/refunds           - Создать возврат
GET    /api/refunds/{id}      - Статус возврата
```

---

## 👨‍💼 Admin Service (port 8005)

### Dashboard
```
GET    /api/admin/dashboard   - Дашборд с аналитикой
GET    /api/admin/stats       - Статистика
```

### Management
```
GET    /api/admin/users       - Управление пользователями
GET    /api/admin/products    - Управление продуктами
GET    /api/admin/orders      - Управление заказами
GET    /api/admin/payments    - Управление платежами
```

### Settings
```
GET    /api/admin/settings    - Настройки системы
PUT    /api/admin/settings    - Обновить настройки
```

### Logs
```
GET    /api/admin/logs        - Системные логи
GET    /api/admin/analytics   - Аналитика и отчеты
```

---

## 🌐 API Gateway (port 9000)

Все запросы идут через Gateway с префиксом:

```
http://localhost:9000/api/{service}/{endpoint}
```

### Примеры:
```
GET  http://localhost:9000/api/auth/me
GET  http://localhost:9000/api/catalog/products
POST http://localhost:9000/api/cart/items
POST http://localhost:9000/api/orders
POST http://localhost:9000/api/payments
GET  http://localhost:9000/api/admin/dashboard
```

---

## 🔑 Аутентификация

Все защищенные endpoints требуют JWT токен в заголовке:

```
Authorization: Bearer {token}
```

### Получение токена:

```bash
curl -X POST http://localhost:9000/api/auth/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }'
```

### Использование токена:

```bash
curl -X GET http://localhost:9000/api/auth/me \
  -H "Authorization: Bearer {your-token}"
```

---

## 📊 Response Format

### Success Response:
```json
{
  "success": true,
  "data": {
    // response data
  },
  "message": "Success message"
}
```

### Error Response:
```json
{
  "success": false,
  "error": {
    "code": 400,
    "message": "Error message",
    "details": {}
  }
}
```

---

## 🚦 HTTP Status Codes

- `200 OK` - Успешный запрос
- `201 Created` - Ресурс создан
- `400 Bad Request` - Неверные данные
- `401 Unauthorized` - Требуется аутентификация
- `403 Forbidden` - Нет прав доступа
- `404 Not Found` - Ресурс не найден
- `422 Unprocessable Entity` - Ошибка валидации
- `500 Internal Server Error` - Ошибка сервера

---

## 📝 Примеры запросов

### Создание заказа:
```bash
curl -X POST http://localhost:9000/api/orders \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "delivery_address": "ул. Пушкина, д. 10",
    "delivery_time": "2025-12-20 18:00:00",
    "payment_method": "card",
    "comment": "Позвоните за 10 минут"
  }'
```

### Добавление в корзину:
```bash
curl -X POST http://localhost:9000/api/cart/items \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "product_id": 1,
    "quantity": 2
  }'
```

### Создание платежа:
```bash
curl -X POST http://localhost:9000/api/payments \
  -H "Authorization: Bearer {token}" \
  -H "Content-Type: application/json" \
  -d '{
    "order_id": 1,
    "amount": 1250.00,
    "payment_method": "card",
    "card_token": "tok_visa"
  }'
```
