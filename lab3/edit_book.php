<?php
require_once("connections/MySiteDB.php");

// Отримуємо ID книги
$book_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Якщо ID не передано – виводимо помилку
if ($book_id == 0) {
    echo "Помилка: не вибрано книгу для редагування.";
    exit;
}

// Отримуємо поточні дані книги
$sql = "SELECT * FROM books WHERE id = $book_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "Помилка: книга не знайдена.";
    exit;
}

$book = $result->fetch_assoc();

// Обробляємо форму редагування
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $author = $conn->real_escape_string($_POST["author"]);
    $year = $conn->real_escape_string($_POST["year"]);
    $author_address = $conn->real_escape_string($_POST["author_address"]);
    $publisher_address = $conn->real_escape_string($_POST["publisher_address"]);
    $price = $conn->real_escape_string($_POST["price"]);
    $bookstore = $conn->real_escape_string($_POST["bookstore"]);

    // Оновлюємо дані книги в базі
    $sql_update = "UPDATE books SET 
        title='$title', 
        author='$author', 
        year='$year', 
        author_address='$author_address', 
        publisher_address='$publisher_address', 
        price='$price', 
        bookstore='$bookstore' 
        WHERE id=$book_id";

    if ($conn->query($sql_update) === TRUE) {
        echo "<p><strong>Книга успішно оновлена!</strong></p>";
    } else {
        echo "<p><strong>Помилка:</strong> " . $conn->error . "</p>";
    }
}
?>

<h2>Редагування книги</h2>

<form method="post">
    <label>Назва книги:</label>
    <input type="text" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required><br>

    <label>Автор:</label>
    <input type="text" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required><br>

    <label>Рік видання:</label>
    <input type="text" name="year" value="<?php echo htmlspecialchars($book['year']); ?>" required pattern="\d{4}" title="Введіть 4-значний рік"><br>

    <label>Адреса автора:</label>
    <input type="text" name="author_address" value="<?php echo htmlspecialchars($book['author_address']); ?>"><br>

    <label>Адреса видавництва:</label>
    <input type="text" name="publisher_address" value="<?php echo htmlspecialchars($book['publisher_address']); ?>"><br>

    <label>Ціна (грн.):</label>
    <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($book['price']); ?>" required><br>

    <label>Книготорговельна фірма:</label>
    <input type="text" name="bookstore" value="<?php echo htmlspecialchars($book['bookstore']); ?>"><br>

    <button type="submit">Зберегти зміни</button>
</form>
