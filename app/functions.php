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
function getLastTime($timeToFinish, $isSeconds = false): string {
    date_default_timezone_set("Europe/Moscow");
    $ts = time();
    $tsToFinish = strtotime($timeToFinish);
    $secsToFinish = $tsToFinish - $ts;
    $hours = floor($secsToFinish / 3600);
    $minutes = floor(($secsToFinish % 3600) / 60);
    if ($isSeconds === false) {
        return "$hours:$minutes";
    } else {
        $sec = $secsToFinish - $hours * 3600 - $minutes * 60;
        return "$hours:$minutes:$sec";
    }
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
function getDataAll(string $sql, $link):array {
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
function getDataArray(string $sql, $link):array {
    $result = mysqli_query($link, $sql);
    if (mysqli_num_rows($result)) {
        return mysqli_fetch_array($result, MYSQLI_ASSOC);
    } else {
        http_response_code(404);
        print renderTemplate('templates/error.php', [
            'error' => mysqli_error($link)
        ]);
        exit();
    }
}
?>
