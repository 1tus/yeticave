<?php
require_once('app/functions.php');
require_once('app/init.php');

session_start();

$lotsList = getDataAll("SELECT l.id, l.name, l.price_start, l.finish_date, l.img_path, c.name AS `category` FROM `lots` l JOIN `categories` c ON l.category_id = c.id WHERE NOW() < l.finish_date ORDER BY l.create_date DESC", $link);

$content = renderTemplate('templates/index.php', [
    'lotsList' => $lotsList
]);
print renderTemplate('templates/layout.php', [
    'title' => 'Главная',
    'userAvatar' => $userAvatar,
    'categories' => $categories,
    'content' => $content
]);

?>
