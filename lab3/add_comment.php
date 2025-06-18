<?php
require_once("connections/MySiteDB.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = intval($_POST["book_id"]);
    $author = $conn->real_escape_string($_POST["author"]);
    $text = $conn->real_escape_string($_POST["text"]);

    $sql = "INSERT INTO comments (book_id, author, text, created_at) VALUES ('$book_id', '$author', '$text', NOW())";

    if ($conn->query($sql) === TRUE) {
        echo "Коментар успішно додано!";
    } else {
        echo "Помилка: " . $conn->error;
    }

    $conn->close();
    
    // Повертаємося на сторінку книги
    header("Location: comments.php?book_id=$book_id");
    exit;
}
?>
