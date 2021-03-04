<?php
require_once('app/functions.php');
require_once('app/init.php');

session_start();

$users = getData('SELECT `email`, `name`, `password_hash`, `avatar_path` FROM `users`', $link);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST;
    $errors = [];
    $required = ['email', 'password'];
    $emptyErrors = [
        'email' => 'Введите e-mail',
        'password' => 'Введите пароль'
    ];
    foreach ($required as $key) {
		if (empty($login[$key])) {
            $errors[$key] = $emptyErrors[$key];
		}
    }
	if (!count($errors)) {
        if ($user = searchUserByEmail($login['email'], $users)) {
            if (password_verify($login['password'], $user['password_hash'])) {
                $_SESSION['user'] = $user;
            } else {
                $errors['password'] = 'Вы ввели неверный пароль';
            }
        } else {
            $errors['email'] = 'Такой пользователь не найден';
        }
	}
    if (count($errors)) {
		$innerContent = renderTemplate('templates/login.php', [
            'categories' => $categories,
            'errors' => $errors,
            'login' => $login,
            'formError' => 'form--invalid'
        ]);
	} else {
        header("Location: /index.php");
		exit();
    }
} else {
    $innerContent = renderTemplate('templates/login.php', [
        'categories' => $categories
    ]);
}
$content = renderTemplate('templates/navigation.php', [
    'categories' => $categories,
    'innerContent' => $innerContent
]);
print renderTemplate('templates/layout.php', [
    'title' => 'Главная',
    'userAvatar' => $userAvatar,
    'categories' => $categories,
    'content' => $content
]);

?>
