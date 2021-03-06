INSERT INTO `categories` (`name`) VALUES
('Доски и лыжи'), ('Крепления'), ('Ботинки'), ('Одежда'), ('Инструменты'), ('Разное');
INSERT INTO `users` (`create_date`, `email`, `name`, `password_hash`, `avatar_path`) VALUES
(NOW(), 'ignat.v@gmail.com', 'Игнат', '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka', ''),
(NOW(), 'kitty_93@li.ru', 'Леночка', '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa', ''),
(NOW(), 'warrior07@mail.ru', 'Руслан', '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW', 'avatar/user.jpg');
INSERT INTO `lots` (`create_date`, `name`, `img_path`, `finish_date`, `price_start`, `price_step`, `autor_id`, `category_id`) VALUES
(NOW(), '2014 Rossignol District Snowboard', 'img/lot-1.jpg', ADDDATE(DATE(ADDDATE(NOW(), INTERVAL 3 DAY)), INTERVAL 0 SECOND), 10999, ROUND(RAND()*9+1)*50, ROUND(RAND()*2+1), 1),
(NOW(), 'DC Ply Mens 2016/2017 Snowboard', 'img/lot-2.jpg', ADDDATE(DATE(ADDDATE(NOW(), INTERVAL 3 DAY)), INTERVAL 0 SECOND), 159999, ROUND(RAND()*9+1)*50, ROUND(RAND()*2+1), 1),
(NOW(), 'Крепления Union Contact Pro 2015 года размер L/XL', 'img/lot-3.jpg', ADDDATE(DATE(ADDDATE(NOW(), INTERVAL 3 DAY)), INTERVAL 0 SECOND), 8000, ROUND(RAND()*9+1)*50, ROUND(RAND()*2+1), 2),
(NOW(), 'Ботинки для сноуборда DC Mutiny Charocal', 'img/lot-4.jpg', ADDDATE(DATE(ADDDATE(NOW(), INTERVAL 3 DAY)), INTERVAL 0 SECOND), 10999, ROUND(RAND()*9+1)*50, ROUND(RAND()*2+1), 3),
(NOW(), 'Куртка для сноуборда DC Mutiny Charocal', 'img/lot-5.jpg', ADDDATE(DATE(ADDDATE(NOW(), INTERVAL 3 DAY)), INTERVAL 0 SECOND), 7500, ROUND(RAND()*9+1)*50, ROUND(RAND()*2+1), 4),
(NOW(), 'Маска Oakley Canopy', 'img/lot-6.jpg', ADDDATE(DATE(ADDDATE(NOW(), INTERVAL 3 DAY)), INTERVAL 0 SECOND), 5400, ROUND(RAND()*9+1)*50, ROUND(RAND()*2+1), 6);
INSERT INTO `bets` (`bet_date`, `bet_price`, `user_id`, `lot_id`) VALUES
(ADDDATE(NOW(), INTERVAL 1 HOUR), 11499, ROUND(RAND()*2+1), 1),
(ADDDATE(NOW(), INTERVAL 2 HOUR), 11999, ROUND(RAND()*2+1), 1),
(ADDDATE(NOW(), INTERVAL 1 HOUR), 160499, ROUND(RAND()*2+1), 2),
(ADDDATE(NOW(), INTERVAL 2 HOUR), 160999, ROUND(RAND()*2+1), 2),
(ADDDATE(NOW(), INTERVAL 1 HOUR), 8500, ROUND(RAND()*2+1), 3),
(ADDDATE(NOW(), INTERVAL 2 HOUR), 9000, ROUND(RAND()*2+1), 3),
(ADDDATE(NOW(), INTERVAL 1 HOUR), 11499, ROUND(RAND()*2+1), 4),
(ADDDATE(NOW(), INTERVAL 2 HOUR), 11999, ROUND(RAND()*2+1), 4),
(ADDDATE(NOW(), INTERVAL 1 HOUR), 8000, ROUND(RAND()*2+1), 5),
(ADDDATE(NOW(), INTERVAL 2 HOUR), 8500, ROUND(RAND()*2+1), 5),
(ADDDATE(NOW(), INTERVAL 1 HOUR), 5900, ROUND(RAND()*2+1), 6),
(ADDDATE(NOW(), INTERVAL 2 HOUR), 6400, ROUND(RAND()*2+1), 6);

-- запросы
SELECT `name` FROM `categories`;
SELECT l.name, l.price_start, l.img_path, MAX(b.bet_price) AS current_price, COUNT(b.lot_id) AS bets_count, c.name FROM `lots` l JOIN `categories` c ON l.category_id = c.id JOIN `bets` b ON l.id = b.lot_id WHERE NOW() < l.finish_date GROUP BY b.lot_id;
SELECT l.id, l.name, c.name AS category_name FROM `lots` l JOIN `categories` c ON l.category_id = c.id WHERE l.id = 1;
UPDATE `lots` l SET l.name = 'Новое название лота' WHERE id = 1;
SELECT b.bet_date, b.bet_price, u.name FROM `bets` b JOIN `users` u ON b.user_id = u.id WHERE b.lot_id = 1 ORDER BY b.bet_price ASC;
