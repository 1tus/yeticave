<?php
require_once('app/functions.php');
require_once('app/init.php');
require_once('app/mysql_helper.php');

session_start();

if (isset($_SESSION['user'])) {
    http_response_code(403);
    exit();
}
$errors = [];
$users = getData('SELECT `email` FROM `users`', $link);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST;
    $required = ['email', 'password', 'name', 'message'];
    $emptyErrors = [
        'email' => 'Введите e-mail',
        'password' => 'Введите пароль',
        'name' => 'Введите имя',
        'message' => 'Напишите как с вами связаться'
    ];
	foreach ($required as $key) {
		if (empty($user[$key])) {
            $errors[$key] = $emptyErrors[$key];
		}
    }
    if (!filter_var($user['email'], FILTER_VALIDATE_EMAIL) && !empty($user['email'])) {
        $errors['email'] = 'Некорректный email';
    }
    if (searchUserByEmail($user['email'], $users)) {
        $errors['email'] = 'Пользователь с таким email уже существует';
    }
    $user['avatar_path'] = '';
    if ($_FILES['avatar-img']['size']) {
        $fInfo = finfo_open(FILEINFO_MIME_TYPE);
        $tmpName = $_FILES['avatar-img']['tmp_name'];
        $mimeType = finfo_file($fInfo, $tmpName);
        if ($mimeType === "image/jpeg") {
            finfo_close($fInfo);
            $path = $_FILES['avatar-img']['name'];
            move_uploaded_file($_FILES['avatar-img']['tmp_name'], "avatar/$path");
            $user['avatar_path'] = "avatar/$path";
        } else {
            $errors[''] = 'Загрузите картинку в формате jpeg';
        }
    }
    if (count($errors)) {
        $innerContent = renderTemplate('templates/sign-up.php', [
            'categories' => $categories,
            'user' => $user,
            'errors' => $errors,
            'formError' => 'form--invalid'
        ]);
    } else {
        $sql = 'INSERT INTO `users` (`create_date`, `email`, `name`, `password_hash`, `avatar_path`, `contact`) VALUES (NOW(), ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt($link, $sql, [
            $user['email'],
            $user['name'],
            password_hash($user['password'], PASSWORD_DEFAULT),
            $user['avatar_path'],
            $user['message']
        ]);
        $res = mysqli_stmt_execute($stmt);
        if ($res) {
            header("Location: /login.php?user=new");
            exit();
        } else {
            print renderTemplate('templates/error.php', [
                'error' => mysqli_error($link)
            ]);
            exit();
        }
    }
} else {
    $innerContent = renderTemplate('templates/sign-up.php', [
        'categories' => $categories,
        'user' => $user
    ]);
}

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
