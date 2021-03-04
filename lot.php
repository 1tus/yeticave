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
	foreach ($lotsList as $key => $lot) {
		if ($key === $lotId) {
            if (isset($_COOKIE['visitedLots'])) {
                $visitedLotsIds = json_decode($_COOKIE['visitedLots']);
                $searchIndex = array_search($key, $visitedLotsIds);
                if ($searchIndex !== false) {
                    unset($visitedLotsIds[$searchIndex]);
                }
            }
            array_unshift($visitedLotsIds, $key);
            setcookie($visitedLots, json_encode($visitedLotsIds), $expire, $path);
			$currentLot = $lot;
            $innerContent = renderTemplate('templates/lot.php', [
                'categories' => $categories,
                'bets' => $bets,
                'lot' => $currentLot
            ]);
            $content = renderTemplate('templates/navigation.php', [
                'categories' => $categories,
                'innerContent' => $innerContent
            ]);
            print renderTemplate('templates/layout.php', [
                'title' => $currentLot['name'],
                'userAvatar' => $userAvatar,
                'categories' => $categories,
                'content' => $content
            ]);
            break;
		}
	}
}
if (!$currentLot) {
    http_response_code(404);
}

?>
