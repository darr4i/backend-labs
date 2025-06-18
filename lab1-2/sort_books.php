<?php
require_once("connections/MySiteDB.php");

// Отримуємо параметр сортування
$sort_by = isset($_GET['sort']) ? $_GET['sort'] : 'created_at';
$order = isset($_GET['order']) ? $_GET['order'] : 'DESC';

// Дозволені варіанти сортування
$allowed_columns = ['title', 'author', 'year', 'price', 'created_at'];
$allowed_orders = ['ASC', 'DESC'];

if (!in_array($sort_by, $allowed_columns)) {
    $sort_by = 'created_at';
}
if (!in_array($order, $allowed_orders)) {
    $order = 'DESC';
}

// Формуємо SQL-запит
$sql = "SELECT * FROM books ORDER BY $sort_by $order";
$result = $conn->query($sql);
?>

<h2>Сортування книг</h2>

<!-- Кнопки сортування -->
<a href="sort_books.php?sort=title&order=ASC">Назва (А-Я)</a> | 
<a href="sort_books.php?sort=title&order=DESC">Назва (Я-А)</a> | 
<a href="sort_books.php?sort=author&order=ASC">Автор (А-Я)</a> | 
<a href="sort_books.php?sort=author&order=DESC">Автор (Я-А)</a> | 
<a href="sort_books.php?sort=year&order=ASC">Рік (старіші спочатку)</a> | 
<a href="sort_books.php?sort=year&order=DESC">Рік (новіші спочатку)</a> | 
<a href="sort_books.php?sort=price&order=ASC">Ціна (дешевші спочатку)</a> | 
<a href="sort_books.php?sort=price&order=DESC">Ціна (дорожчі спочатку)</a> | 
<a href="sort_books.php?sort=created_at&order=DESC">Новіші спочатку</a> | 
<a href="sort_books.php?sort=created_at&order=ASC">Старіші спочатку</a>

<hr>

<?php
// Виводимо книги у вибраному порядку
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px;'>";
        echo "<strong>Назва:</strong> " . htmlspecialchars($row["title"]) . "<br>";
        echo "<strong>Автор:</strong> " . htmlspecialchars($row["author"]) . "<br>";
        echo "<strong>Рік видання:</strong> " . htmlspecialchars($row["year"]) . "<br>";
        echo "<strong>Ціна:</strong> " . htmlspecialchars($row["price"]) . " грн.<br>";
        echo "<strong>Дата додавання:</strong> " . htmlspecialchars($row["created_at"]) . "<br>";
        echo "</div>";
    }
} else {
    echo "Книг поки що немає.";
}

$conn->close();
?>
