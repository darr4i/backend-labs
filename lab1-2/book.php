<?php
require_once("connections/MySiteDB.php");

// Обробка форми після відправки
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $conn->real_escape_string($_POST["title"]);
    $author = $conn->real_escape_string($_POST["author"]);
    $year = $conn->real_escape_string($_POST["year"]);
    $author_address = $conn->real_escape_string($_POST["author_address"]);
    $publisher_address = $conn->real_escape_string($_POST["publisher_address"]);
    $price = $conn->real_escape_string($_POST["price"]);
    $bookstore = $conn->real_escape_string($_POST["bookstore"]);

    // SQL-запит для додавання книги
    $sql = "INSERT INTO books (title, author, year, author_address, publisher_address, price, bookstore) 
            VALUES ('$title', '$author', '$year', '$author_address', '$publisher_address', '$price', '$bookstore')";

    if ($conn->query($sql) === TRUE) {
        $message = "Книга успішно додана!";
    } else {
        $message = "Помилка: " . $conn->error;
    }

    $conn->close();
}
?>

<h2>Додавання нової книги</h2>

<!-- Виведення повідомлення про успіх або помилку -->
<?php if (isset($message)) echo "<p><strong>$message</strong></p>"; ?>

<form method="post">
    <label>Назва книги:</label>
    <input type="text" name="title" required><br>

    <label>Автор:</label>
    <input type="text" name="author" required><br>

    <label>Рік видання:</label>
    <input type="text" name="year" required pattern="\d{4}" title="Введіть 4-значний рік"><br>

    <label>Адреса автора:</label>
    <input type="text" name="author_address"><br>

    <label>Адреса видавництва:</label>
    <input type="text" name="publisher_address"><br>

    <label>Ціна (грн.):</label>
    <input type="number" step="0.01" name="price" required><br>

    <label>Книготорговельна фірма:</label>
    <input type="text" name="bookstore"><br>

    <button type="submit">Додати книгу</button>
</form>
