CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_unicode_ci;

USE yeticave;

CREATE TABLE categories (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `name` VARCHAR(128) NOT NULL
);
CREATE TABLE lots (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `create_date` DATETIME NOT NULL,
  `name` VARCHAR(128) NOT NULL,
  `description` TEXT(2048),
  `img_path` VARCHAR(128) NOT NULL,
  `price_start` DECIMAL(10,0) NOT NULL,
  `finish_date` DATETIME NOT NULL,
  `price_step` DECIMAL(10,0) NOT NULL,
  `likes_count` INT UNSIGNED,
  `autor_id` INT UNSIGNED NOT NULL,
  `winner_id` INT UNSIGNED,
  `category_id` INT UNSIGNED NOT NULL
);
CREATE TABLE bets (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `bet_date` DATETIME NOT NULL,
  `bet_price` DECIMAL(10,0) NOT NULL,
  `user_id` INT UNSIGNED NOT NULL,
  `lot_id` INT UNSIGNED NOT NULL
);
CREATE TABLE users (
  `id` INT UNSIGNED AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `create_date` DATETIME NOT NULL,
  `email` VARCHAR(128) NOT NULL,
  `name` VARCHAR(64) NOT NULL,
  `password_hash` VARCHAR(128) NOT NULL,
  `avatar_path` VARCHAR(128),
  `contact` TEXT(1024)
);

CREATE UNIQUE INDEX `name` ON categories(`name`);
CREATE UNIQUE INDEX `email` ON users(`email`);
CREATE FULLTEXT INDEX search ON  lots(name, description);
