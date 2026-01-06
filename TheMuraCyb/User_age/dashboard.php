<?php
session_start();
require_once '../db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="../styles/auth.css">
</head>
<body>
    <h1>Добро пожаловать, <?= htmlspecialchars($_SESSION['fullname']) ?>!</h1>
    <p style="text-align: center; font-size: 24px; margin: 50px;">Ты способен на большее! Продолжай учиться!</p>
    
    <div style="text-align: center; margin: 30px;">
        <a href="videos.php" style="margin: 10px; padding: 15px; font-size: 20px; text-decoration: none;">📹 Видео</a>
        <a href="photos.php" style="margin: 10px; padding: 15px; font-size: 20px; text-decoration: none;">🖼 Фото</a>
        <a href="files.php" style="margin: 10px; padding: 15px; font-size: 20px; text-decoration: none;">📁 Файлы</a>
    </div>

    <div style="position: absolute; top: 10px; right: 10px;">
        <select onchange="alert('Переводчик скоро будет :)')">
            <option>Русский</option>
            <option>O'zbek</option>
        </select>
    </div>

    <a href="../logout.php">Выйти</a>
</body>
</html>