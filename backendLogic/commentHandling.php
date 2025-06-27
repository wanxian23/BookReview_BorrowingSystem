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

            if (!empty($_POST['comment'])) {

                $comment = trim($_POST['comment']);
                $rating = trim($_POST['rating']);

                // Set Time Zone (Malaysia KL)
                date_default_timezone_set("Asia/Kuala_Lumpur");
                $todayDate = date("l, F j, Y");
                $todayTime = date("H:i:s");

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

                $sqlComment = "INSERT INTO Comment_Rating (postCode, readerID, comment, dateComment, timeComment, rating, statusComment)
                               VALUES ('{$post['postCode']}','$readerID','$comment','$todayDate','$todayTime','$rating','APPROVED')";
                $resultSqlComment = $conn->query($sqlComment);

                $sqlGetCommentDetails = "SELECT *
                                         FROM Comment_Rating
                                         WHERE postCode = '{$post['postCode']}' AND
                                         readerID = '$readerID'
                                         ORDER BY commentCode DESC";
                $resultGetCommentDetails = $conn->query($sqlGetCommentDetails);
                $commentDetails = $resultGetCommentDetails->fetch_assoc();

                $sqlNotification = "INSERT INTO Notification (postCode, readerID, commentCode, status) 
                                    VALUES ('{$post['postCode']}','$readerID','{$commentDetails['commentCode']}','UNREAD')";
                $resultNotification = $conn->query($sqlNotification);

                if ($resultSqlComment && $resultNotification) {
                    echo "Comment Posted Successfully!";
                    echo "<meta http-equiv='refresh' content='3; url=../bookDetail.php?postCode=$postCode'>";
                } else {
                    echo "Comment Failed!";
                    echo "<meta http-equiv='refresh' content='3; url=../bookDetail.php?postCode=$postCode'>";
                }

            }
        }

    }

    ?>

    </main>

    <?php include("../footer.html"); ?>
    
</body>
</html>