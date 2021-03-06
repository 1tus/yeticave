<?php
function renderTemplate(string $fullpath, array $variables): string {
    if (!file_exists($fullpath)) {
        return 'Файл не найден';
    }
    ob_start();
    extract($variables);
    include_once($fullpath);
    return ob_get_clean();
}
function formatPrice(float $price): string {
    return number_format($price, 0, '', ' ') . ' ₽';
}
function getLastTime(): string {
    date_default_timezone_set("Europe/Moscow");
    $ts = time();
    $tsMidnight = strtotime('tomorrow');
    $secsToMidnight = $tsMidnight - $ts;
    $hours = floor($secsToMidnight / 3600);
    $minutes = floor(($secsToMidnight % 3600) / 60);
    return "$hours:$minutes";
}
function searchUserByEmail($email, $users) {
    $result = null;
    foreach ($users as $user) {
        if ($user['email'] === $email) {
            $result = $user;
            break;;
        }
    }
    return $result;
}
function getData(string $sql, $link):array {
    $result = mysqli_query($link, $sql);
    if ($result) {
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        print renderTemplate('templates/error.php', [
            'error' => mysqli_error($link)
        ]);
        exit();
    }
}
?>
