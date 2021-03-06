<?php

require_once('app/functions.php');

$link = mysqli_connect('127.0.0.1', 'root', '1111', 'yeticave');

if (!$link) {
    $error = mysqli_connect_error();
    print renderTemplate('templates/error.php', [
        'error' => $error
    ]);
    exit();
} else {
    $categories = getData('SELECT `name` FROM `categories` ORDER BY `id` ASC', $link);
    $lotsList = getData('SELECT l.id, l.name, l.price_start, l.img_path, c.name AS `category`, MAX(b.bet_price) AS current_price FROM `lots` l JOIN `categories` c ON l.category_id = c.id JOIN `bets` b ON l.id = b.lot_id WHERE NOW() < l.finish_date GROUP BY b.lot_id ORDER BY l.id ASC', $link);
}

mysqli_set_charset($link, 'utf8');

?>
