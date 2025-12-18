# SimpleFood Microservices - Quick Start Guide

## 🚀 Быстрый старт с Laragon

### 1. Подготовка окружения

1. Убедитесь, что Laragon установлен и запущен
2. Убедитесь, что Docker Desktop установлен и работает
3. Клонируйте репозиторий в директорию Laragon:
   ```bash
   cd C:\laragon\www
   git clone <repo-url> SimpleFood-monolith
   cd SimpleFood-monolith
   ```

### 2. Запуск с Docker (рекомендуется)

#### Windows (Laragon):
```bash
# Запуск всех сервисов
scripts\start-all.bat

# Или вручную:
docker-compose up -d
```

#### Linux/Mac:
```bash
# Запуск всех сервисов
chmod +x scripts/start-all.sh
./scripts/start-all.sh

# Или вручную:
docker-compose up -d
```

### 3. Проверка работы сервисов

Откройте браузер и проверьте:
- http://localhost:9000 - API Gateway
- http://localhost:8001 - Auth Service
- http://localhost:8002 - Catalog Service
- http://localhost:8003 - Cart Service
- http://localhost:8000 - Order Service
- http://localhost:8004 - Payment Service
- http://localhost:8005 - Admin Service

### 4. Инициализация баз данных

```bash
# Для каждого сервиса запустите миграции
docker exec simplefood-auth-service php artisan migrate
docker exec simplefood-catalog-service php artisan migrate
docker exec simplefood-cart-service php artisan migrate
docker exec simplefood-order-service php artisan migrate
docker exec simplefood-payment-service php artisan migrate
docker exec simplefood-admin-service php artisan migrate
```

### 5. Загрузка тестовых данных

```bash
docker exec simplefood-catalog-service php artisan db:seed
docker exec simplefood-auth-service php artisan db:seed
```

---

## 🔧 Разработка с Laragon (без Docker)

Если хотите разрабатывать без Docker, используя Laragon:

### 1. Настройка баз данных

Создайте 6 баз данных в HeidiSQL (Laragon):
- `auth_db`
- `catalog_db`
- `cart_db`
- `orders_db`
- `payments_db`
- `admin_db`

### 2. Настройка виртуальных хостов

Добавьте в `C:\Windows\System32\drivers\etc\hosts`:
```
127.0.0.1 auth-service.test
127.0.0.1 catalog-service.test
127.0.0.1 cart-service.test
127.0.0.1 order-service.test
127.0.0.1 payment-service.test
127.0.0.1 admin-service.test
127.0.0.1 api-gateway.test
```

### 3. Создайте виртуальные хосты в Laragon

Для каждого сервиса в Laragon:
1. Right-click Laragon → Apache → sites-enabled → Добавьте конфиги
2. Или используйте Laragon Menu → Quick app → Configuration

Пример конфига для auth-service (`C:\laragon\etc\apache2\sites-enabled\auth-service.conf`):
```apache
<VirtualHost *:8001>
    DocumentRoot "C:/laragon/www/SimpleFood-monolith/services/auth-service/public"
    ServerName auth-service.test
    <Directory "C:/laragon/www/SimpleFood-monolith/services/auth-service/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

### 4. Установка зависимостей

Для каждого сервиса:
```bash
cd services/auth-service
composer install

cd ../catalog-service
composer install

# И так далее для всех сервисов
```

### 5. Настройка .env файлов

Для каждого сервиса создайте `.env` из `.env.example` и настройте:
```bash
cd services/auth-service
copy .env.example .env
php artisan key:generate
```

Обновите подключения к БД в каждом `.env`:
```env
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=auth_db
DB_USERNAME=root
DB_PASSWORD=
```

---

## 🧪 Тестирование

### Запуск всех тестов:

Windows:
```bash
scripts\run-all-tests.bat
```

Linux/Mac:
```bash
chmod +x scripts/run-all-tests.sh
./scripts/run-all-tests.sh
```

### Запуск тестов для конкретного сервиса:

```bash
cd services/auth-service
composer test
```

---

## 📊 Мониторинг

### Docker логи:
```bash
# Все сервисы
docker-compose logs -f

# Конкретный сервис
docker-compose logs -f auth-service
```

### RabbitMQ Management:
http://localhost:15672
- Username: `admin`
- Password: `admin`

---

## 🔄 Миграция данных из монолита

См. [MIGRATION_GUIDE.md](MIGRATION_GUIDE.md) для подробных инструкций.

---

## 🛠 Полезные команды

### Docker:
```bash
# Остановить все сервисы
docker-compose down

# Пересобрать образы
docker-compose build

# Очистить volumes
docker-compose down -v

# Посмотреть статус
docker-compose ps
```

### Laravel Artisan:
```bash
# Внутри контейнера
docker exec -it simplefood-auth-service bash
php artisan migrate
php artisan db:seed
php artisan cache:clear

# Или напрямую
docker exec simplefood-auth-service php artisan migrate
```

---

## 🐛 Решение проблем

### Порты заняты:
Если порты 8000-8005, 9000 заняты, измените их в `docker-compose.yml`

### Ошибка подключения к БД:
Проверьте, что все MySQL контейнеры запущены:
```bash
docker-compose ps
```

### Composer ошибки:
Очистите кеш и переустановите зависимости:
```bash
docker exec simplefood-auth-service composer clear-cache
docker exec simplefood-auth-service composer install
```

### Права доступа (Linux):
```bash
sudo chown -R $USER:$USER .
chmod -R 775 services/*/storage services/*/bootstrap/cache
```

---

## 📚 Дополнительная документация

- [API Documentation](API_DOCUMENTATION.md)
- [Migration Guide](MIGRATION_GUIDE.md)
- [Architecture Overview](README.md)

---

## ✅ Checklist для запуска

- [ ] Docker Desktop установлен и запущен
- [ ] Laragon установлен (опционально)
- [ ] Репозиторий клонирован
- [ ] `docker-compose up -d` выполнен успешно
- [ ] Все сервисы доступны (проверьте браузером)
- [ ] Миграции выполнены для всех сервисов
- [ ] Тестовые данные загружены
- [ ] Тесты проходят успешно

---

Готово! Теперь вы можете начать разработку 🎉
