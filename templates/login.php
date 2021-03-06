<?php if ($_GET['user'] === 'new'): ?>
    <div>Теперь вы можете войти, используя свой email и пароль</div>
<?php endif; ?>
<form class="form container <?= $formError ?>" action="login.php" method="post" enctype="multipart/form-data">
    <h2>Вход</h2>
    <div class="form__item <?= $errors['email'] ? 'form__item--invalid' : '' ?>">
        <label for="email">E-mail*</label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?= $login['email'] ?? '' ?>">
        <span class="form__error"><?= $errors['email'] ?></span>
    </div>
    <div class="form__item form__item--last <?= $errors['password'] ? 'form__item--invalid' : '' ?>">
        <label for="password">Пароль*</label>
        <input id="password" type="text" name="password" placeholder="Введите пароль" value="<?= $login['password'] ?? '' ?>">
        <span class="form__error"><?= $errors['password'] ?></span>
    </div>
    <button type="submit" class="button">Войти</button>
</form>
