<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "users_1st";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}
?>
