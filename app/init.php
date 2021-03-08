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
    $categories = getDataAll("SELECT `name` FROM `categories` ORDER BY `id` ASC", $link);
}

mysqli_set_charset($link, 'utf8');

?>
