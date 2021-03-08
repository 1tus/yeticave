<?php
require_once('app/functions.php');
require_once('app/init.php');

session_start();

$visitedLots = "visitedLots";
$visitedLotsIds = [];
$expire = strtotime("+30 days");
$path = "/";
$currentLot = null;

if (isset($_GET['id'])) {
	$lotId = intval($_GET['id']);
    $lot = getDataArray("SELECT l.name, l.description, l.price_start, l.finish_date, l.img_path, c.name AS `category` FROM `lots` l JOIN `categories` c ON l.category_id = c.id WHERE l.id = $lotId", $link);
    $bets = getDataAll("SELECT b.bet_date, b.bet_price, u.name FROM `bets` b JOIN `users` u ON b.user_id = u.id WHERE b.lot_id = $lotId ORDER BY b.bet_price ASC", $link);

    $lot['current_price'] = $lot['price_start'];

    // if (isset($_COOKIE['visitedLots'])) {
    //     $visitedLotsIds = json_decode($_COOKIE['visitedLots']);
    //     $searchIndex = array_search($key, $visitedLotsIds);
    //     if ($searchIndex !== false) {
    //         unset($visitedLotsIds[$searchIndex]);
    //     }
    // }
    // array_unshift($visitedLotsIds, $key);
    // setcookie($visitedLots, json_encode($visitedLotsIds), $expire, $path);
    $innerContent = renderTemplate('templates/lot.php', [
        // 'bets' => $bets,
        'lot' => $lot
    ]);
    $content = renderTemplate('templates/navigation.php', [
        'categories' => $categories,
        'innerContent' => $innerContent
    ]);
    print renderTemplate('templates/layout.php', [
        'title' => $lot['name'],
        'userAvatar' => $userAvatar,
        'categories' => $categories,
        'content' => $content
    ]);
}

?>
