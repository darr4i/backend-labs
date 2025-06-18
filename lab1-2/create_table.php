<?php
// 1. Параметри підключення до сервера MySQL
$servername = "localhost"; // Якщо сервер локальний
$username = "admin"; // Ваш логін
$password = "admin"; // Ваш пароль
$dbname = "MySiteDB"; // Назва бази даних

// 2. Створюємо з'єднання
$conn = new mysqli($servername, $username, $password, $dbname);

// 3. Перевіряємо з'єднання
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// 4. Формуємо SQL-запит для створення таблиці notes
$sql = "CREATE TABLE notes (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    created DATE,
    title VARCHAR(20),
    article VARCHAR(255)
)";

// 5. Виконуємо запит
if ($conn->query($sql) === TRUE) {
    echo "Таблиця notes успішно створена!";
} else {
    echo "Помилка створення таблиці: " . $conn->error;
}

// 6. Закриваємо підключення
$conn->close();
?>
