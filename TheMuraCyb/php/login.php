<?php
session_start();
require_once 'db.php';  // подключаем нашу БД

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
    // Обычный вход email + пароль
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if ($email && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            if ($user['role'] === 'admin' && $user['admin_approved'] == 0) {
                $error = 'Аккаунт администратора не одобрен.';
            } else {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['fullname'] = $user['fullname'];
                $_SESSION['role'] = $user['role'];
                redirectByRole($user['role']);
            }
        } else {
            $error = 'Неверный email или пароль';
        }
    } else {
        $error = 'Заполните все поля';
    }
}

// Google вход (упрощённый вариант без JWT библиотеки)
if (isset($_POST['credential'])) {
    $credential = $_POST['credential'];
    $parts = explode('.', $credential);
    if (count($parts) === 3) {
        $payload = json_decode(base64_decode(strtr($parts[1], '-_', '+/')), true);
        if ($payload && $payload['email_verified']) {
            $google_id = $payload['sub'];
            $email = $payload['email'];
            $fullname = $payload['name'];

            $stmt = $pdo->prepare("SELECT * FROM users WHERE google_id = ? OR email = ?");
            $stmt->execute([$google_id, $email]);
            $user = $stmt->fetch();

            if ($user) {
                if ($user['role'] === 'admin' && $user['admin_approved'] == 0) {
                    $error = 'Аккаунт администратора не одобрен.';
                } else {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['role'] = $user['role'];
                    redirectByRole($user['role']);
                }
            } else {
                // Авторегистрация как обычный пользователь
                $stmt = $pdo->prepare("INSERT INTO users (fullname, email, google_id, role) VALUES (?, ?, ?, 'user')");
                $stmt->execute([$fullname, $email, $google_id]);
                $_SESSION['user_id'] = $pdo->lastInsertId();
                $_SESSION['fullname'] = $fullname;
                $_SESSION['role'] = 'user';
                redirectByRole('user');
            }
        }
    }
}

function redirectByRole($role) {
    if ($role === 'admin') {
        header('Location: Admin_page/dashboard.php');
    } else {
        header('Location: User_page/dashboard.php');
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | TheMuracyb</title>
    <link rel="stylesheet" href="styles/auth.css">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
</head>
<body>
    <div class="login-box">
        <h2>Вход в систему</h2>
        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <!-- Обычная форма -->
        <form method="POST">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Пароль" required>
            <button type="submit">Войти</button>
        </form>

        <div style="margin: 20px 0; text-align: center;">или</div>

        <!-- Google кнопка -->
        <div id="g_id_onload"
             data-client_id="ВСТАВЬ_СВОЙ_GOOGLE_CLIENT_ID_СЮДА"
             data-callback="handleCredentialResponse">
        </div>
        <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline" data-text="signin_with"></div>

        <div style="text-align: center; margin-top: 20px;">
            Нет аккаунта? <a href="register.php">Регистрация</a>
        </div>
    </div>

    <script>
        function handleCredentialResponse(response) {
            const form = document.createElement('form');
            form.method = 'POST';
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'credential';
            input.value = response.credential;
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>