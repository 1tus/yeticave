<?php
require_once('app/functions.php');
require_once('app/init.php');

session_start();

if (!isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $lot = $_POST;
    $errors = [];
    $required = ['lot-name', 'message', 'lot-rate', 'lot-step', 'lot-date'];
    $emptyErrors = [
        'lot-name' => 'Введите наименование лота',
        'message' => 'Напишите описание лота',
        'lot-rate' => 'Введите начальную цену',
        'lot-step' => 'Введите шаг ставки',
        'lot-date' => 'Введите дату завершения торгов'
    ];
	foreach ($required as $key) {
		if (empty($lot[$key])) {
            $errors[$key] = $emptyErrors[$key];
		}
    }
    if ($lot['category'] === 'Выберите категорию') {
        $errors['category'] = 'Выберите категорию';
    }
    if (!filter_var($lot['lot-rate'], FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) && !empty($lot['lot-rate'])) {
        $errors['lot-rate'] = 'Цена должна быть больше 0';
    }
    if (!filter_var($lot['lot-step'], FILTER_VALIDATE_INT, array('options' => array('min_range' => 1))) && !empty($lot['lot-step'])) {
        $errors['lot-step'] = 'Шаг должен быть больше 0';
    }
    if (strtotime($lot['lot-date']) - time() < 0 && !empty($lot['lot-date'])) {
        $errors['lot-date'] = 'Дата должна больше текущей';
    }
    $imgUploaded = '';
	if ($_FILES['lot-img']['size']) {
        $fInfo = finfo_open(FILEINFO_MIME_TYPE);
        $tmpName = $_FILES['lot-img']['tmp_name'];
        $mimeType = finfo_file($fInfo, $tmpName);
        if ($mimeType === "image/jpeg") {
            finfo_close($fInfo);
            $path = $_FILES['lot-img']['name'];
            move_uploaded_file($_FILES['lot-img']['tmp_name'], "img/$path");
            $lot['path'] = "img/$path";
            $imgUploaded = 'form__item--uploaded';
        } else {
            $errors['file'] = 'Загрузите картинку в формате jpeg';
        }
    } else {
		$errors['file'] = 'Вы не загрузили файл';
    }
    if (count($errors)) {
		$innerContent = renderTemplate('templates/add.php', [
            'errors' => $errors,
            'lot' => $lot,
            'formError' => 'form--invalid',
            'imgUploaded' => $imgUploaded
        ]);
	} else {
        $innerContent = renderTemplate('templates/lot.php', [
            'errors' => $errors,
            'lot' => $lot
        ]);
    }
} else {
	$innerContent = renderTemplate('templates/add.php', [
    ]);
}
$content = renderTemplate('templates/navigation.php', [
    'categories' => $categories,
    'innerContent' => $innerContent
]);
print renderTemplate('templates/layout.php', [
    'title' => 'Добавление лота',
    'userAvatar' => $userAvatar,
    'categories' => $categories,
    'content' => $content
]);

?>

