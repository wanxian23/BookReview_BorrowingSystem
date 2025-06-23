<?php

$server = "localhost";
$root = "bookSpare";
$password = "1234";
$tableDB = "student_bookspare";

$conn = new mysqli($server, $root, $password, $tableDB);

if ($conn->connect_error) {
    echo "Database Connection Failed!";
} else {
    // echo "Database Connected Successfully!";
}
?>