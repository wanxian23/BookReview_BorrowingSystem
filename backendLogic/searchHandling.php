<?php 

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

require("../database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];
$readerId = $_SESSION['readerID'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username' 
OR email = '$email' OR phone = '$contact'";
$runSQL = $conn->query($sql);

$user = $runSQL->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include("headDetails.html"); ?>
    <title>Redirecting..</title>

    <style>
        
        main {
            text-align: center;
            margin: 5% 6%;
            font-size: 1.3em;
        }
    </style>
</head>
<body>

    <?php include("header.php"); ?>

    <main>

    <?php

        

    ?>

    </main>

    <?php include("../footer.html"); ?>
    
</body>
</html>