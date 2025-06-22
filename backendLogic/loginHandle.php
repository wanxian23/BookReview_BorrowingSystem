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
require("../database/database.php");

// Save user input into session if coming from POST
if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact']) && $_SERVER['REQUEST_METHOD'] === "POST") {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['email'] = $_POST['username'];
    $_SESSION['contact'] = $_POST['username'];
    $_SESSION['pass'] = $_POST['password'];
}

if (isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'], $_SESSION['pass'])) {
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $contact = $_SESSION['contact'];
    $pass = $_SESSION['pass'];

    $sql = "SELECT * FROM Reader_User 
            WHERE username = '$username' OR email = '$email' OR phone = '$contact'";
    $runSQL = $conn->query($sql);

    if ($runSQL->num_rows === 1) {
        $user = $runSQL->fetch_assoc();
        $_SESSION['readerID'] = $user['readerID'];

        if (password_verify($pass, $user['password'])) {
            echo "Login Successful! Redirecting...";

            // Redirect to intended page if set
            if (isset($_SESSION['bookReviewLogin'])) {
                $redirectURL = $_SESSION['bookReviewLogin'];
                unset($_SESSION['redirectAfterLogin']);
                echo "<meta http-equiv='refresh' content='3; URL=$redirectURL'>";
            } else {
                echo "<meta http-equiv='refresh' content='3; URL=../main.php'>";
            }
        } else {
            echo "Login Failed! Wrong Password!";
            echo "<meta http-equiv='refresh' content='3; URL=../login.php'>";
        }
    } else {
        echo "Login Failed! Account Doesn't Exist!";
        echo "<meta http-equiv='refresh' content='3; URL=../login.php'>";
    }
}

$conn->close();
?>

</main>
</body>
</html>
