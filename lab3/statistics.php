<?php
require_once("connections/MySiteDB.php");

echo "<h2>📊 Статистика сайту</h2>";

// Загальна кількість книг
$sql_total_books = "SELECT COUNT(id) AS total_books FROM books";
$result_total_books = $conn->query($sql_total_books);
$row_total_books = $result_total_books->fetch_assoc();
$total_books = $row_total_books['total_books'];
echo "<p><strong>Загальна кількість книг:</strong> $total_books</p>";

// Загальна кількість коментарів
$sql_total_comments = "SELECT COUNT(id) AS total_comments FROM comments";
$result_total_comments = $conn->query($sql_total_comments);
$row_total_comments = $result_total_comments->fetch_assoc();
$total_comments = $row_total_comments['total_comments'];
echo "<p><strong>Загальна кількість коментарів:</strong> $total_comments</p>";

// Отримання початку та кінця поточного місяця
$date_array = getdate();
$begin_date = date("Y-m-d", mktime(0, 0, 0, $date_array['mon'], 1, $date_array['year']));
$end_date = date("Y-m-d", mktime(0, 0, 0, $date_array['mon'] + 1, 0, $date_array['year']));

// Кількість книг, доданих за останній місяць
$sql_books_month = "SELECT COUNT(id) AS books_month FROM books WHERE created_at >= '$begin_date' AND created_at <= '$end_date'";
$result_books_month = $conn->query($sql_books_month);
$row_books_month = $result_books_month->fetch_assoc();
$books_month = $row_books_month['books_month'];
echo "<p><strong>Кількість книг за останній місяць:</strong> $books_month</p>";

// Кількість коментарів, доданих за останній місяць
$sql_comments_month = "SELECT COUNT(id) AS comments_month FROM comments WHERE created_at >= '$begin_date' AND created_at <= '$end_date'";
$result_comments_month = $conn->query($sql_comments_month);
$row_comments_month = $result_comments_month->fetch_assoc();
$comments_month = $row_comments_month['comments_month'];
echo "<p><strong>Кількість коментарів за останній місяць:</strong> $comments_month</p>";

// Остання додана книга
$sql_last_book = "SELECT title, created_at FROM books ORDER BY created_at DESC LIMIT 1";
$result_last_book = $conn->query($sql_last_book);
if ($result_last_book->num_rows > 0) {
    $row_last_book = $result_last_book->fetch_assoc();
    echo "<p><strong>Остання додана книга:</strong> " . htmlspecialchars($row_last_book['title']) . " (дата: " . $row_last_book['created_at'] . ")</p>";
} else {
    echo "<p><strong>Остання додана книга:</strong> Немає записів</p>";
}

// Книга з найбільшою кількістю коментарів
$sql_most_commented = "SELECT books.title, COUNT(comments.id) AS comment_count 
                       FROM books 
                       LEFT JOIN comments ON books.id = comments.book_id 
                       GROUP BY books.id 
                       ORDER BY comment_count DESC 
                       LIMIT 1";
$result_most_commented = $conn->query($sql_most_commented);
if ($result_most_commented->num_rows > 0) {
    $row_most_commented = $result_most_commented->fetch_assoc();
    echo "<p><strong>Книга з найбільшою кількістю коментарів:</strong> " . htmlspecialchars($row_most_commented['title']) . " (коментарів: " . $row_most_commented['comment_count'] . ")</p>";
} else {
    echo "<p><strong>Книга з найбільшою кількістю коментарів:</strong> Немає записів</p>";
}

$conn->close();
?>
