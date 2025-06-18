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

// Отримуємо всі замітки
$sql = "SELECT * FROM notes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($note = $result->fetch_assoc()) {
        echo "<h3>" . $note["title"] . " (" . $note["created"] . ")</h3>";
        echo "<p>" . $note["article"] . "</p>";
        
        // Отримуємо коментарі для цієї замітки
        $note_id = $note["id"];
        $comment_sql = "SELECT * FROM comments WHERE note_id = $note_id";
        $comment_result = $conn->query($comment_sql);

        if ($comment_result->num_rows > 0) {
            echo "<h4>Коментарі:</h4>";
            while ($comment = $comment_result->fetch_assoc()) {
                echo "<p><b>" . $comment["author"] . ":</b> " . $comment["comment"] . " (" . $comment["created_at"] . ")</p>";
            }
        } else {
            echo "<p>Коментарів поки немає.</p>";
        }
        echo "<hr>";
    }
} else {
    echo "Немає жодної замітки.";
}

$conn->close();
?>
