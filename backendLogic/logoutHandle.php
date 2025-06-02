<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirecting</title>

    <link rel="stylesheet" href="../style.css">

    <style>
        main {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 130px;
            font-size: 1.5em;
        }
    </style>
</head>
<body>

<main>

    <?php 
    // If not null
    if (isset($_SESSION['username'])) {

        // Clear all $_SESSION variables that create in other form
        // Like username and password
        $_SESSION = array();

        // Destroy the session so that wont crash with others
        session_destroy();
        echo "Logout Successfully! Redirecting...";
        echo "<meta http-equiv='refresh' content='3;URL=/BookReview_BorrowingSystem/login.php'>";
    }
    ?>

</main>

</body>
</html>
