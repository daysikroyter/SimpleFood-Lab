# Payment Service

Микросервис обработки платежей для SimpleFood application.

## Описание

Payment Service отвечает за:
- Обработку платежей
- Интеграцию с платежными шлюзами (Stripe, PayPal)
- Управление транзакциями
- Обработку webhooks от платежных систем
- Возвраты и отмены платежей
- Историю платежей пользователя

## Требования

- PHP >= 8.2
- Composer
- SQLite или MySQL/PostgreSQL
- Stripe Account (для production)
- PayPal Account (для production)

## Установка

```bash
# Установка зависимостей
composer install

# Копирование .env файла
cp .env.example .env

# Генерация ключа приложения
php artisan key:generate

# Запуск миграций
php artisan migrate
```

## Конфигурация

Настройте ключи платежных систем в файле `.env`:

```env
STRIPE_KEY=your_stripe_key
STRIPE_SECRET=your_stripe_secret
STRIPE_WEBHOOK_SECRET=your_webhook_secret

PAYPAL_MODE=sandbox
PAYPAL_CLIENT_ID=your_paypal_client_id
PAYPAL_SECRET=your_paypal_secret
```

## API Endpoints

- `POST /api/payments/create` - Создать платеж
- `POST /api/payments/{id}/confirm` - Подтвердить платеж
- `POST /api/payments/{id}/cancel` - Отменить платеж
- `POST /api/payments/{id}/refund` - Вернуть средства
- `GET /api/payments/{id}` - Получить информацию о платеже
- `GET /api/payments/history` - История платежей пользователя
- `POST /api/webhooks/stripe` - Webhook для Stripe
- `POST /api/webhooks/paypal` - Webhook для PayPal

## Тестирование

```bash
composer test
```

## Разработка

```bash
php artisan serve --port=8004
```

## Интеграции

Сервис взаимодействует с:
- **Order Service** - для обновления статуса заказа
- **Auth Service** - для аутентификации пользователей
- **Stripe API** - платежный шлюз
- **PayPal API** - платежный шлюз

## Безопасность

- Все платежные данные шифруются
- Используется HTTPS для всех запросов
- Webhooks проверяются на подлинность
- PCI DSS compliance

## Лицензия

MIT
