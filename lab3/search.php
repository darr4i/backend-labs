<?php
require_once("connections/MySiteDB.php");

$search_query = "";
$search_results = [];
$error = "";

// Виконання пошуку
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $search_type = $_POST["search_type"];

    // Пошук за ключовим словом (назва або автор)
    if ($search_type == "keyword") {
        $keyword = $conn->real_escape_string($_POST["keyword"]);
        $sql = "SELECT * FROM books WHERE title LIKE '%$keyword%' OR author LIKE '%$keyword%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $search_results[] = $row;
            }
        } else {
            $error = "Нічого не знайдено за запитом '$keyword'.";
        }
    }

    // Пошук за шаблоном (назва починається з певної літери)
    elseif ($search_type == "pattern") {
        $pattern = $conn->real_escape_string($_POST["pattern"]);
        $sql = "SELECT * FROM books WHERE title LIKE '$pattern%'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $search_results[] = $row;
            }
        } else {
            $error = "Нічого не знайдено для шаблону '$pattern%'.";
        }
    }

    // Пошук у діапазоні цін
    elseif ($search_type == "range") {
        $min_price = floatval($_POST["min_price"]);
        $max_price = floatval($_POST["max_price"]);
        $sql = "SELECT * FROM books WHERE price BETWEEN $min_price AND $max_price";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $search_results[] = $row;
            }
        } else {
            $error = "Немає книг у діапазоні цін від $min_price до $max_price грн.";
        }
    }
}
?>

<h2>🔍 Пошук книг</h2>

<!-- Форма пошуку -->
<form method="post">
    <label><strong>Виберіть тип пошуку:</strong></label>
    <select name="search_type" required>
        <option value="keyword">Пошук за ключовим словом</option>
        <option value="pattern">Пошук за шаблоном</option>
        <option value="range">Пошук у діапазоні цін</option>
    </select><br><br>

    <!-- Поле для пошуку за ключовим словом -->
    <div id="keyword_search">
        <label>Введіть ключове слово:</label>
        <input type="text" name="keyword"><br>
    </div>

    <!-- Поле для пошуку за шаблоном -->
    <div id="pattern_search" style="display: none;">
        <label>Введіть першу літеру назви:</label>
        <input type="text" name="pattern" maxlength="1"><br>
    </div>

    <!-- Поля для пошуку в діапазоні цін -->
    <div id="range_search" style="display: none;">
        <label>Мінімальна ціна:</label>
        <input type="number" step="0.01" name="min_price"><br>
        <label>Максимальна ціна:</label>
        <input type="number" step="0.01" name="max_price"><br>
    </div>

    <br>
    <button type="submit">🔍 Знайти</button>
</form>

<hr>

<!-- Виведення результатів -->
<?php
if (!empty($search_results)) {
    echo "<h3>📚 Результати пошуку:</h3>";
    foreach ($search_results as $book) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px;'>";
        echo "<strong>Назва:</strong> " . htmlspecialchars($book["title"]) . "<br>";
        echo "<strong>Автор:</strong> " . htmlspecialchars($book["author"]) . "<br>";
        echo "<strong>Рік видання:</strong> " . htmlspecialchars($book["year"]) . "<br>";
        echo "<strong>Ціна:</strong> " . htmlspecialchars($book["price"]) . " грн.<br>";
        echo "</div>";
    }
} elseif (!empty($error)) {
    echo "<p style='color: red;'><strong>$error</strong></p>";
}
?>

<script>
document.querySelector("select[name='search_type']").addEventListener("change", function () {
    document.getElementById("keyword_search").style.display = "none";
    document.getElementById("pattern_search").style.display = "none";
    document.getElementById("range_search").style.display = "none";

    if (this.value === "keyword") {
        document.getElementById("keyword_search").style.display = "block";
    } else if (this.value === "pattern") {
        document.getElementById("pattern_search").style.display = "block";
    } else if (this.value === "range") {
        document.getElementById("range_search").style.display = "block";
    }
});
</script>
