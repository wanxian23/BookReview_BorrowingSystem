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
            $reportReason = $_POST['reportReason'];

            $extraReason = "";
            if (isset($_POST['extraReason'])) {
                $extraReason = $_POST['extraReason'];
            }

            // Set Time Zone (Malaysia KL)
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $todayDateTime = date("Y-m-d H:i:s"); 

            $sqlUpdatePostStatus = "UPDATE post_review SET statusApprove = 'SUSPICIOUS' WHERE postCode = '$postCode'";
            $resultUpdatePostStatus = $conn->query($sqlUpdatePostStatus);

            $sqlReport = "INSERT INTO post_report (reason, extraReason, reportDateTime, postCode, readerID)
                          VALUES ('$reportReason','$extraReason','$todayDateTime','$postCode','$readerID')";
            $resultReport= $conn->query($sqlReport);

            if ($resultUpdatePostStatus && $resultReport) {
                echo "Post Report Successfully!";
                echo "<meta http-equiv='refresh' content='3; url=../main.php'>";
            } else {
                echo "Post Failed To Report!";
                echo "<meta http-equiv='refresh' content='3; url=../bookDetail.php?postCode=$postCode'>";
            }

        }

    }

    ?>

    </main>

    <?php include("../footer.html"); ?>
    
</body>
</html>