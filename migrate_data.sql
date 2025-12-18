orders_db-- Копирование данных из монолита в микросервисы

-- ОЧИСТКА ТАБЛИЦ ПЕРЕД ИМПОРТОМ
SET FOREIGN_KEY_CHECKS = 0;

USE auth_db;
TRUNCATE TABLE users;

USE catalog_db;
TRUNCATE TABLE product_reviews;
TRUNCATE TABLE products;
TRUNCATE TABLE categories;

USE cart_db;
TRUNCATE TABLE cart_items;

USE orders_db;
TRUNCATE TABLE orders;

SET FOREIGN_KEY_CHECKS = 1;

-- 1. Копируем пользователей в auth_db
USE auth_db;
INSERT INTO users (id, name, email, password, is_admin, created_at, updated_at)
SELECT id, name, email, password, is_admin, created_at, updated_at
FROM simple_food.users;

-- 2. Копируем категории и продукты в catalog_db
USE catalog_db;
INSERT INTO categories (id, name, description, created_at, updated_at)
SELECT id, name, description, created_at, updated_at
FROM simple_food.categories;

INSERT INTO products (id, category_id, name, description, price, image, created_at, updated_at)
SELECT id, category_id, name, description, price, image, created_at, updated_at
FROM simple_food.products;

INSERT INTO product_reviews (id, product_id, user_id, rating, comment, created_at, updated_at)
SELECT id, product_id, user_id, rating, comment, created_at, updated_at
FROM simple_food.product_reviews;

-- 3. Копируем корзины в cart_db
USE cart_db;
INSERT INTO cart_items (id, user_id, product_id, quantity, created_at, updated_at)
SELECT id, user_id, product_id, quantity, created_at, updated_at
FROM simple_food.cart_items;

-- 4. Копируем заказы в orders_db
USE orders_db;
INSERT IGNORE INTO orders (id, user_id, status, total_amount, delivery_address, payment_method, created_at, updated_at)
SELECT id, user_id, status, total_amount, delivery_address, payment_method, created_at, updated_at
FROM simple_food.orders;

-- Проверка
SELECT 'auth_db users:' as info, COUNT(*) as count FROM auth_db.users
UNION ALL
SELECT 'catalog_db categories:', COUNT(*) FROM catalog_db.categories
UNION ALL
SELECT 'catalog_db products:', COUNT(*) FROM catalog_db.products
UNION ALL
SELECT 'cart_db cart_items:', COUNT(*) FROM cart_db.cart_items
UNION ALL
SELECT 'orders_db orders:', COUNT(*) FROM orders_db.orders;
