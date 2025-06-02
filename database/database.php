<?php

$server = "localhost:3301";
$root = "root";
$password = "1234";
$tableDB = "bookspare";

$conn = new mysqli($server, $root, $password, $tableDB);

if ($conn->connect_error) {
    echo "Database Connection Failed!";
} else {
    // echo "Database Connected Successfully!";
}
?>