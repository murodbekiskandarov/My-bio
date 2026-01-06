<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="../styles/auth.css">
</head>
<body>
    <h1>Админ-панель</h1>
    <p>Добро пожаловать, <?= htmlspecialchars($_SESSION['fullname']) ?>!</p>
    <p>Здесь ты будешь добавлять видео, фото, файлы и управлять контентом.</p>
    <a href="../logout.php">Выйти</a>
</body>
</html>