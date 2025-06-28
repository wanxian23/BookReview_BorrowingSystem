<?php 

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

require("../database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];
$readerID = $_SESSION['readerID'];

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
    
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (isset($_REQUEST['postCode'])) {

            $postCode = $_REQUEST['postCode'];
            
            $sqlCancelBorrowRequest = "DELETE FROM book_borrowed WHERE postCode = '$postCode' AND readerID = '$readerID'";
            $resultCancelBorrowRequest = $conn->query($sqlCancelBorrowRequest);

            if ($resultCancelBorrowRequest) {
                echo "Borrow Request Cancelled Successfully!";
                echo "<meta http-equiv='refresh' content='3;url=../bookDetail.php?postCode=$postCode'>";
            } else {
                echo "Borrow Request Failed to Cancel!";
                echo "<meta http-equiv='refresh' content='3; url=../bookDetail.php?postCode=$postCode'>";
            }

        }
    }


    ?>

    </main>

    <?php include("../footer.html"); ?>
    
</body>
</html>