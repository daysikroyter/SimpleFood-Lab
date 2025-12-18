.PHONY: help build up down restart logs test clean migrate seed install

help: ## Показать справку
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}'

build: ## Собрать все Docker образы
	docker-compose build

up: ## Запустить все сервисы
	docker-compose up -d
	@echo "✅ Все сервисы запущены!"
	@echo "API Gateway: http://localhost:9000"

down: ## Остановить все сервисы
	docker-compose down

restart: ## Перезапустить все сервисы
	docker-compose restart

logs: ## Показать логи всех сервисов
	docker-compose logs -f

logs-auth: ## Логи Auth Service
	docker-compose logs -f auth-service

logs-catalog: ## Логи Catalog Service
	docker-compose logs -f catalog-service

logs-cart: ## Логи Cart Service
	docker-compose logs -f cart-service

logs-order: ## Логи Order Service
	docker-compose logs -f order-service

logs-payment: ## Логи Payment Service
	docker-compose logs -f payment-service

logs-admin: ## Логи Admin Service
	docker-compose logs -f admin-service

test: ## Запустить все тесты
	@echo "🧪 Запуск тестов для всех сервисов..."
	@cd services/auth-service && composer test
	@cd services/catalog-service && composer test
	@cd services/cart-service && composer test
	@cd services/order-service && composer test
	@cd services/payment-service && composer test
	@cd services/admin-service && composer test
	@echo "✅ Все тесты пройдены!"

test-auth: ## Тесты Auth Service
	docker exec simplefood-auth-service composer test

test-catalog: ## Тесты Catalog Service
	docker exec simplefood-catalog-service composer test

test-cart: ## Тесты Cart Service
	docker exec simplefood-cart-service composer test

test-order: ## Тесты Order Service
	docker exec simplefood-order-service composer test

test-payment: ## Тесты Payment Service
	docker exec simplefood-payment-service composer test

test-admin: ## Тесты Admin Service
	docker exec simplefood-admin-service composer test

migrate: ## Выполнить миграции для всех сервисов
	@echo "🔄 Выполнение миграций..."
	docker exec simplefood-auth-service php artisan migrate
	docker exec simplefood-catalog-service php artisan migrate
	docker exec simplefood-cart-service php artisan migrate
	docker exec simplefood-order-service php artisan migrate
	docker exec simplefood-payment-service php artisan migrate
	docker exec simplefood-admin-service php artisan migrate
	@echo "✅ Миграции выполнены!"

migrate-fresh: ## Пересоздать все таблицы
	@echo "⚠️  ВНИМАНИЕ: Все данные будут удалены!"
	docker exec simplefood-auth-service php artisan migrate:fresh
	docker exec simplefood-catalog-service php artisan migrate:fresh
	docker exec simplefood-cart-service php artisan migrate:fresh
	docker exec simplefood-order-service php artisan migrate:fresh
	docker exec simplefood-payment-service php artisan migrate:fresh
	docker exec simplefood-admin-service php artisan migrate:fresh

seed: ## Загрузить тестовые данные
	@echo "🌱 Загрузка тестовых данных..."
	docker exec simplefood-auth-service php artisan db:seed
	docker exec simplefood-catalog-service php artisan db:seed
	@echo "✅ Данные загружены!"

install: ## Установить зависимости для всех сервисов
	@echo "📦 Установка зависимостей..."
	docker exec simplefood-auth-service composer install
	docker exec simplefood-catalog-service composer install
	docker exec simplefood-cart-service composer install
	docker exec simplefood-order-service composer install
	docker exec simplefood-payment-service composer install
	docker exec simplefood-admin-service composer install
	docker exec simplefood-api-gateway composer install
	@echo "✅ Зависимости установлены!"

clean: ## Очистить кеши и volumes
	docker-compose down -v
	@echo "✅ Volumes удалены!"

ps: ## Показать статус сервисов
	docker-compose ps

shell-auth: ## Войти в контейнер Auth Service
	docker exec -it simplefood-auth-service bash

shell-catalog: ## Войти в контейнер Catalog Service
	docker exec -it simplefood-catalog-service bash

shell-cart: ## Войти в контейнер Cart Service
	docker exec -it simplefood-cart-service bash

shell-order: ## Войти в контейнер Order Service
	docker exec -it simplefood-order-service bash

shell-payment: ## Войти в контейнер Payment Service
	docker exec -it simplefood-payment-service bash

shell-admin: ## Войти в контейнер Admin Service
	docker exec -it simplefood-admin-service bash

setup: build up migrate seed ## Полная установка проекта
	@echo "🎉 Проект установлен и готов к работе!"
	@echo "API Gateway: http://localhost:9000"

dev: ## Режим разработки с логами
	docker-compose up

prod: ## Запуск в продакшн режиме
	docker-compose -f docker-compose.prod.yml up -d

backup-db: ## Создать бэкап всех баз данных
	@echo "💾 Создание бэкапов баз данных..."
	@mkdir -p backups
	docker exec simplefood-mysql-auth mysqldump -uroot -psecret auth_db > backups/auth_db_$$(date +%Y%m%d_%H%M%S).sql
	docker exec simplefood-mysql-catalog mysqldump -uroot -psecret catalog_db > backups/catalog_db_$$(date +%Y%m%d_%H%M%S).sql
	docker exec simplefood-mysql-cart mysqldump -uroot -psecret cart_db > backups/cart_db_$$(date +%Y%m%d_%H%M%S).sql
	docker exec simplefood-mysql-orders mysqldump -uroot -psecret orders_db > backups/orders_db_$$(date +%Y%m%d_%H%M%S).sql
	docker exec simplefood-mysql-payments mysqldump -uroot -psecret payments_db > backups/payments_db_$$(date +%Y%m%d_%H%M%S).sql
	docker exec simplefood-mysql-admin mysqldump -uroot -psecret admin_db > backups/admin_db_$$(date +%Y%m%d_%H%M%S).sql
	@echo "✅ Бэкапы созданы в папке backups/"

stats: ## Показать статистику Docker
	docker stats
