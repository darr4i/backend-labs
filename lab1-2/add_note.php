<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MySiteDB";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка з'єднання
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// SQL-запит для вставки даних
$sql = "INSERT INTO notes (created, title, article) 
        VALUES (CURDATE(), 'Мій перший запис', 'Це тестова замітка в блозі.')";

if ($conn->query($sql) === TRUE) {
    echo "Запис успішно додано!";
} else {
    echo "Помилка: " . $conn->error;
}

// Закриваємо підключення
$conn->close();
?>
