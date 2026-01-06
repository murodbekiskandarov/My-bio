<?php
$host = 'localhost';
$db   = 'themuracyb';    // замени на реальное имя твоей базы данных
$user = 'root';          // обычно root в XAMPP
$pass = '';              // обычно пустой в XAMPP
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die('Ошибка подключения к БД: ' . $e->getMessage());
}
?>