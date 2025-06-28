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
            $sqlGetPostDetails = "SELECT 
                                    post.*,
                                    reader.*,
                                    book.*
                                FROM post_review post
                                INNER JOIN reader_user reader USING (readerID)
                                INNER JOIN book_record book USING (bookID)
                                WHERE post.postCode = '$postCode'";
            $resultGetPostDetails = $conn->query($sqlGetPostDetails);
            $post = $resultGetPostDetails->fetch_assoc();

                // Set Time Zone (Malaysia KL)
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $todayDateTime = date("Y-m-d H:i:s"); 

                $sqlBorrowRequest = "INSERT INTO book_borrowed (readerID, postCode, statusBorrow, dateRequestSent)
                                      VALUES ('$readerID','$postCode','PENDING','$todayDateTime')";
                $resultSqlBorrowRequest = $conn->query($sqlBorrowRequest);

                $sqlGetBorrowRequestInfo = "SELECT * FROM book_borrowed
                                            WHERE postCode = '$postCode' AND readerID = '$readerID'
                                            ORDER BY bookBorrowCode DESC LIMIT 1";
                $resultGetBorrowRequestInfo = $conn->query($sqlGetBorrowRequestInfo);
                $borrowRequest = $resultGetBorrowRequestInfo->fetch_assoc();

                $sqlNotification = "INSERT INTO Notification (postCode, readerID, bookBorrowCode, status) 
                                    VALUES ('$postCode','$readerID','{$borrowRequest['bookBorrowCode']}','UNREAD')";
                $resultNotification = $conn->query($sqlNotification);

                if ($resultSqlBorrowRequest &&  $resultNotification) {
                    echo "Borrow Request Sent Successfully!";
                    echo "<meta http-equiv='refresh' content='3;url=../borrowDetails.php?section=pendingApprove&sectionAside=pendingRequest'>";
                } else {
                    echo "Borrow Request Failed to Send!";
                    echo "<meta http-equiv='refresh' content='3; url=../bookDetail.php?postCode=$postCode'>";
                }

        }
    }


    ?>

    </main>

    <?php include("../footer.html"); ?>
    
</body>
</html>