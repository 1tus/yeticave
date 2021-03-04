<?php
require_once('app/functions.php');
require_once('app/init.php');

session_start();

if (isset($_COOKIE['visitedLots'])) {
    $visitedLotsIds = json_decode($_COOKIE['visitedLots']);
    $innerContent = renderTemplate('templates/history.php', [
        'categories' => $categories,
        'lotsList' => $lotsList,
        'visitedLotsIds' => $visitedLotsIds
    ]);
} else {
    $innerContent = 'История просмотров отсутствует';
}
$content = renderTemplate('templates/navigation.php', [
    'categories' => $categories,
    'innerContent' => $innerContent
]);
print renderTemplate('templates/layout.php', [
    'title' => 'Главная',
    'categories' => $categories,
    'content' => $content
]);

?>
