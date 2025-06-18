<?php
require_once("connections/MySiteDB.php");

// Вибираємо всі книги, сортуємо за датою додавання (останнє – вгорі)
$sql = "SELECT * FROM books ORDER BY created_at DESC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px; padding-bottom: 15px;'>";
        echo "<a href='edit_book.php?id=" . $row["id"] . "' style='display: block; margin-bottom: 5px; font-weight: bold; color: blue;'>Редагувати</a>";
        echo "<strong>Назва:</strong> <a href='comments.php?book_id=" . $row["id"] . "'>" . htmlspecialchars($row["title"]) . "</a><br>";
        echo "<strong>Автор:</strong> " . htmlspecialchars($row["author"]) . "<br>";
        echo "<strong>Рік видання:</strong> " . htmlspecialchars($row["year"]) . "<br>";
        echo "<strong>Адреса автора:</strong> " . htmlspecialchars($row["author_address"]) . "<br>";
        echo "<strong>Адреса видавництва:</strong> " . htmlspecialchars($row["publisher_address"]) . "<br>";
        echo "<strong>Ціна:</strong> " . htmlspecialchars($row["price"]) . " грн.<br>";
        echo "<strong>Книготорговельна фірма:</strong> " . htmlspecialchars($row["bookstore"]) . "<br>";
        echo "<strong>Дата додавання:</strong> " . htmlspecialchars($row["created_at"]) . "<br>";
        echo "<a href='delete_book.php?id=" . $row["id"] . "' style='display: block; margin-bottom: 10px; font-weight: bold; color: red;' onclick='return confirm(\"Ви впевнені, що хочете видалити цю книгу?\");'>Видалити</a>";
        echo "</div>";
    }
} else {
    echo "Книг поки що немає.";
}

$conn->close();
?>
