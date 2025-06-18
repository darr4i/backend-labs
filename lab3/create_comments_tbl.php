<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MySiteDB";

// Підключення до MySQL
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// SQL-запит для створення таблиці comments з зовнішнім ключем
$sql = "CREATE TABLE IF NOT EXISTS comments (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    note_id INT NOT NULL,
    author VARCHAR(50) NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (note_id) REFERENCES notes(id) ON DELETE CASCADE
)";

if ($conn->query($sql) === TRUE) {
    echo "Таблиця comments успішно створена з зовнішнім ключем!";
} else {
    echo "Помилка створення таблиці: " . $conn->error;
}

$conn->close();
?>
