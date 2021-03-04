<?php
require_once('app/functions.php');
require_once('app/init.php');

session_start();

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
