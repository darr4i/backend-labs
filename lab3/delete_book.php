<?php
require_once("connections/MySiteDB.php");

// Отримуємо параметри
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$return_to_comments = isset($_GET['return_to_comments']) ? intval($_GET['return_to_comments']) : 0;

// Якщо ID книги не передано – виводимо помилку
if ($book_id == 0) {
    die("Помилка: не вибрано книгу для видалення.");
}

// Видаляємо книгу з бази
$sql = "DELETE FROM books WHERE id = $book_id";
if ($conn->query($sql) === TRUE) {
    echo "<p><strong>Книга успішно видалена!</strong></p>";
} else {
    echo "<p><strong>Помилка:</strong> " . $conn->error . "</p>";
}

$conn->close();

// Якщо користувач прийшов зі сторінки коментарів – повертаємо його назад
if ($return_to_comments) {
    echo "<p><a href='comments.php?book_id=$book_id'>Повернутися до коментарів</a></p>";
} else {
    // Якщо користувач прийшов зі сторінки списку книг – повертаємо його на список
    echo "<p><a href='view_books.php'>Повернутися до списку книг</a></p>";
}
?>
