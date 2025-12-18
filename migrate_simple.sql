-- Категории  
USE catalog_db;
TRUNCATE TABLE categories;
INSERT INTO categories SELECT * FROM simple_food.categories;

-- Продукты
TRUNCATE TABLE products;
INSERT INTO products SELECT * FROM simple_food.products;

-- Пользователи
USE auth_db;
TRUNCATE TABLE users;
INSERT INTO users SELECT * FROM simple_food.users;

-- Проверка
SELECT 'Users' as Info, COUNT(*) as Count FROM auth_db.users
UNION ALL
SELECT 'Categories', COUNT(*) FROM catalog_db.categories
UNION ALL
SELECT 'Products', COUNT(*) FROM catalog_db.products;