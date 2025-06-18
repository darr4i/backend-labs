<?php
require_once("connections/MySiteDB.php");

$sql = "SELECT * FROM notes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div style='border: 1px solid #ccc; padding: 10px; margin: 10px;'>";
        echo "<strong>ID:</strong> " . $row["id"] . "<br>";
        echo "<strong>Дата:</strong> " . $row["created"] . "<br>";
        echo "<strong><a href='comments.php?note=" . $row["id"] . "'>" . $row["title"] . "</a></strong><br>";
        echo "<strong>Текст:</strong> " . $row["article"] . "<br>";
        echo "</div>";
    }
} else {
    echo "Записів поки що немає.";
}

$conn->close();
?>
