<?php
require_once("connections/MySiteDB.php");

// Отримуємо ID книги з GET-запиту
$book_id = isset($_GET["book_id"]) ? intval($_GET["book_id"]) : 0;

if ($book_id == 0) {
    echo "Помилка: не вибрано книгу.";
    exit;
}

// Отримуємо інформацію про книгу
$sql_book = "SELECT * FROM books WHERE id = $book_id";
$result_book = $conn->query($sql_book);

if ($result_book->num_rows > 0) {
    $book = $result_book->fetch_assoc();
    echo "<h2>" . htmlspecialchars($book["title"]) . "</h2>";
    echo "<p><strong>Автор:</strong> " . htmlspecialchars($book["author"]) . "</p>";
    echo "<p><strong>Рік:</strong> " . htmlspecialchars($book["year"]) . "</p>";
    echo "<p><strong>Ціна:</strong> " . htmlspecialchars($book["price"]) . " грн.</p>";
} else {
    echo "Книга не знайдена.";
    exit;
}

echo "<hr>";

// Отримуємо всі коментарі до книги
$sql_comments = "SELECT * FROM comments WHERE book_id = $book_id ORDER BY created_at DESC";
$result_comments = $conn->query($sql_comments);

echo "<h3>Коментарі:</h3>";

if ($result_comments->num_rows > 0) {
    while ($comment = $result_comments->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px 0;'>";
        echo "<p><strong>" . htmlspecialchars($comment["author"]) . "</strong> ";
        echo "<em>(" . htmlspecialchars($comment["created_at"]) . ")</em></p>";
        echo "<p>" . nl2br(htmlspecialchars($comment["text"])) . "</p>";
        echo "</div>";
    }
} else {
    echo "<p><em>Цей запис ще ніхто не коментував.</em></p>";
}

$conn->close();
?>

<!-- Кнопка для видалення книги -->
<h3>Видалення книги</h3>
<a href="delete_book.php?id=<?php echo $book_id; ?>&return_to_comments=1" 
   style="color: red; font-weight: bold;" 
   onclick="return confirm('Ви впевнені, що хочете видалити цю книгу?');">
   Видалити книгу
</a>

<!-- Форма для додавання коментаря -->
<h3>Додати коментар:</h3>
<form action="add_comment.php" method="post">
    <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
    <label>Ім'я:</label>
    <input type="text" name="author" required><br>
    
    <label>Коментар:</label>
    <textarea name="text" required></textarea><br>
    
    <button type="submit">Додати коментар</button>
</form>
