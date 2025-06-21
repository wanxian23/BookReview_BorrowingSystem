<?php
require("database/database.php");

if (isset($_POST['query'])) {
    $keyword = $conn->real_escape_string($_POST['query']);

    $sql = "SELECT bookTitle FROM book_record WHERE bookTitle LIKE '%$keyword%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $book = $result->fetch_assoc();
        foreach($book as $data) {
            echo "<div>" . htmlspecialchars($data['bookTitle']) . "</div>";
        }
    } else {
        echo "<div>No matches found</div>";
    }
}
?>
