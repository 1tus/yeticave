<?php
require_once('app/functions.php');
require_once('app/init.php');

$innerContent = renderTemplate('templates/sign-up.php', [
    'categories' => $categories
]);
$content = renderTemplate('templates/navigation.php', [
    'categories' => $categories,
    'innerContent' => $innerContent
]);
print renderTemplate('templates/layout.php', [
    'title' => 'Регистрация',
    'userAvatar' => $userAvatar,
    'categories' => $categories,
    'content' => $content
]);

?>
