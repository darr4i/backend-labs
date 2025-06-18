<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MySiteDB";

// Створення підключення
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}
?>
