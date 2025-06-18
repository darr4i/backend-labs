<?php
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MySiteDB";

// Підключення до бази даних
$conn = new mysqli($servername, $username, $password, $dbname);

// Перевірка підключення
if ($conn->connect_error) {
    die("Помилка підключення: " . $conn->connect_error);
}

// SQL-запит на вибірку даних
$sql = "SELECT id, created, title, article FROM notes";
$result = $conn->query($sql);

// Відображення результатів
if ($result->num_rows > 0) {
    echo "<h2>Список заміток:</h2>";
    while ($row = $result->fetch_assoc()) {
        echo "<b>" . $row["title"] . "</b> (" . $row["created"] . ")<br>";
        echo $row["article"] . "<hr>";
    }
} else {
    echo "Немає жодного запису.";
}

// Закриваємо підключення
$conn->close();
?>
