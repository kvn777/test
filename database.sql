CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_name VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL
);

CREATE TABLE user_carts (
    cart_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- Индексы записал здесь, пишу на основании запросов, но в жизни скорее всего нужны будут индексы по таблице пользователей: по email и password
-- Вспоминая пояснение что можно по составному индексу использовать только первое значение, то для этой задачи достаточно одного индекса
CREATE INDEX user_product ON user_carts(user_id, product_id);

-- Запрос, который вернёт список товаров пользователя
SELECT -- перечилить все поля какие нужны или поставить *
    FROM user_carts
JOIN products ON user_carts.product_id = products.id
    WHERE user_carts.user_id = 1;

-- Запрос, который покажет, есть ли у конкретного пользователя конкретный товар
SELECT COUNT(*) AS count FROM user_carts
    WHERE user_id = 1 AND product_id = 1;


-- Запрос, который получает список всех пользователей, у которых корзина пуста, т.е. нет записей в таблице user_carts
-- вариант 1
SELECT users.id FROM users WHERE id NOT IN (SELECT user_id FROM user_carts);
-- вариант 2, здесь я вспомнил разговор про Null и Left Join
SELECT users.id FROM users
    LEFT JOIN user_carts ON users.id = user_carts.user_id
    WHERE user_carts.user_id IS NULL;
-- Сложно сказать какой запрос быстрее, второй возможно будет быстрее, но результаты на холодной базе показывают примерно одинаковое время
-- Проверял 5млн корзин, 100к товаров и 100к пользоватей, размер БД был близким к 500мб