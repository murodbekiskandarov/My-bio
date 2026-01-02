<?php
session_start();

$errors = [
    'login' => $_SESSION['login_error'] ?? '',
    'register' => $_SESSION['register_error'] ?? ''
];

$activeForm = $_SESSION['active_form'] ?? 'login';

// НЕ очищаем полностью, только ошибки, чтобы active_form оставался
unset($_SESSION['login_error'], $_SESSION['register_error']);

function showError($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isActiveForm($formName, $activeForm) {
    return $formName === $activeForm ? 'active' : '';
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>

    <div class="container">

        <!-- LOGIN FORM -->
        <div id="login" class="form-box <?= isActiveForm('login', $activeForm); ?>">

            <form action="login_register.php" method="post">
                <h2>Вход</h2>
                <?= showError($errors['login']); ?>

                <input type="email" name="email" placeholder="Эмаил" required>
                <input type="password" name="password" placeholder="Пароль" required>

                <button type="submit" name="login">Зайти</button>

                <p>У тебя нет аккаунта?
                    <a href="#" onclick="showForm('register'); return false;">Регистрация</a>
                </p>
            </form>
        </div>

        <!-- REGISTER FORM -->
        <div id="register" class="form-box <?= isActiveForm('register', $activeForm); ?>">
            <form action="login_register.php" method="post">
                <a href="#" onclick="showForm('register'); return false;">Регистрация</a>
                <?= showError($errors['register']); ?>

                <input type="text" name="name" placeholder="Имя">
                <input type="email" name="email" placeholder="Эмаил" required>
                <input type="password" name="password" placeholder="Пароль" required>

                <select name="role" required>
                    <option value="">Выбрать</option>
                    <option value="user">Пользователь</option>
                    <option value="admin">Админ</option>
                </select>

                <button type="submit" name="register">Зарегистрироваться</button>

                <p>Уже есть аккаунт?
                   <a href="#" onclick="showForm('login'); return false;">Вход</a>
                </p>
            </form>
        </div>

    </div>

<script src="./assets/js/login.js"></script>

</body>
</html>


