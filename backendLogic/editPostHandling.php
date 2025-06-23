<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
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

        $bookTitle = trim($_POST['book_title']);
        $genre = $_POST['genre'];
        $opinion = $_POST['your_opinion'];
        $author = $_POST['author'];
        $review = $_POST['review'];

        $thread = [];
        if (isset($_POST['removeThread'])) {
            $thread = $_POST['removeThread'];
        }

        if (isset($_POST['public_phone_number'])) {
            $statusPhone = "YES";
        } else {
            $statusPhone = "NO";
        }
        
        $sqlCheckBook = "SELECT * FROM book_record WHERE bookTitle LIKE '$bookTitle'";
        $resultCheckBook = $conn->query($sqlCheckBook);
        $book = "";

        if ($resultCheckBook->num_rows > 0) {
            $book = $resultCheckBook->fetch_assoc();
        } else {
            $sqlCreateBook = "INSERT INTO Book_Record (bookTitle) VALUES ('$bookTitle')";
            $resultCreateBook = $conn->query($sqlCreateBook);
        }

        $threadData = "";    
        foreach ($thread as $threadData) {
            $data = trim($threadData);
            $sqlThreadCheck = "SELECT * FROM Thread WHERE thread LIKE '$data'";
            $resultCheckThread = $conn->query($sqlThreadCheck); 
            
            if ($resultCheckThread->num_rows > 0) {
                $threadData = $resultCheckThread->fetch_assoc();
            } else {
                $sqlCreateThread = "INSERT INTO Thread (thread) VALUES ('$data')";
                $resultCreateThread = $conn->query($sqlCreateThread);            
            }
        }

        $sqlCheckBook = "SELECT * FROM book_record WHERE bookTitle LIKE '$bookTitle'";
        $resultCheckBook = $conn->query($sqlCheckBook);
        $book = $resultCheckBook->fetch_assoc();
        $bookTitleChoose = $book['bookTitle'];
        $bookCode = $book['bookID'];

        if ($post['frontCover_img'] != null) { 

            if (isset($_FILES['front_cover']) && $_FILES['front_cover']['error'] == 0) {
                $bookUploads = "bookUploads/";
                if (!is_dir("../".$bookUploads)) mkdir("../".$bookUploads, "0755", true);

                $frontCoverPath = $bookUploads . uniqid("img_") . "_" . basename($_FILES['front_cover']['name']);

                move_uploaded_file($_FILES['front_cover']['tmp_name'], "../".$frontCoverPath);
            }

            if (isset($_FILES['back_cover']) && $_FILES['back_cover']['error'] == 0) {
                $bookUploads = "bookUploads/";
                if (!is_dir("../".$bookUploads)) mkdir("../".$bookUploads, "0755", true);

                $backCoverPath = $bookUploads . uniqid("img_") . "_" . basename($_FILES['back_cover']['name']);

                move_uploaded_file($_FILES['back_cover']['tmp_name'], "../".$backCoverPath);
            }

            $synopsis = mysqli_real_escape_string($conn, $_POST['synopsis']);
            
            if ((isset($_FILES['front_cover']) && $_FILES['front_cover']['error'] == 0) && (isset($_FILES['back_cover']) && $_FILES['back_cover']['error'] == 0)) {
                $sqlCreatePost = "UPDATE post_review 
                                SET readerID = '$readerId',
                                bookID = '$bookCode',
                                ownerOpinion = '$opinion',
                                ownerRating = '$review',
                                frontCover_img = '$frontCoverPath',
                                backCover_img = '$backCoverPath',
                                synopsis = '$synopsis',
                                statusPhone = '$statusPhone',
                                author = '$author',
                                genre = '$genre'
                                WHERE postCode = '$postCode'";
                $runSqlCreatePost = $conn->query($sqlCreatePost);                 
            } else if ((isset($_FILES['front_cover']) && $_FILES['front_cover']['error'] == 0) && (!isset($_FILES['back_cover']) || $_FILES['back_cover']['error'] != 0)) {
                $sqlCreatePost = "UPDATE post_review 
                                SET readerID = '$readerId',
                                bookID = '$bookCode',
                                ownerOpinion = '$opinion',
                                ownerRating = '$review',
                                frontCover_img = '$frontCoverPath',
                                synopsis = '$synopsis',
                                statusPhone = '$statusPhone',
                                author = '$author',
                                genre = '$genre'
                                WHERE postCode = '$postCode'";
                $runSqlCreatePost = $conn->query($sqlCreatePost); 
            } else if ((!isset($_FILES['front_cover']) || $_FILES['front_cover']['error'] != 0) && (isset($_FILES['back_cover']) && $_FILES['back_cover']['error'] == 0)) {
                $sqlCreatePost = "UPDATE post_review 
                                SET readerID = '$readerId',
                                bookID = '$bookCode',
                                ownerOpinion = '$opinion',
                                ownerRating = '$review',
                                backCover_img = '$backCoverPath',
                                synopsis = '$synopsis',
                                statusPhone = '$statusPhone',
                                author = '$author',
                                genre = '$genre'
                                WHERE postCode = '$postCode'";
                $runSqlCreatePost = $conn->query($sqlCreatePost);   
            } else {
                $sqlCreatePost = "UPDATE post_review 
                                SET readerID = '$readerId',
                                bookID = '$bookCode',
                                ownerOpinion = '$opinion',
                                ownerRating = '$review',
                                synopsis = '$synopsis',
                                statusPhone = '$statusPhone',
                                author = '$author',
                                genre = '$genre'
                                WHERE postCode = '$postCode'";
                $runSqlCreatePost = $conn->query($sqlCreatePost);   
            }
            
            if ($runSqlCreatePost) {

                foreach ($thread as $threadData) {
                    $data = trim($threadData);
                    $sqlThreadCheck = "SELECT * FROM Thread WHERE thread LIKE '$data'";
                    $resultCheckThread = $conn->query($sqlThreadCheck); 
                    $threadData = $resultCheckThread->fetch_assoc();
                    $threadChoose = $threadData['threadID'];

                    $sqlLinkThread = "INSERT INTO Thread_Post (postCode, threadID) VALUES ('$postCode','$threadChoose')";
                    $resultLinkThread = $conn->query($sqlLinkThread);            
                }

                echo "POST UPDATED SUCCESSFULLY!";
                echo "<meta http-equiv='refresh' content='3; url=../mainmyposts.php'>";
            } else {
                echo "FAILED TO UPDATE POST! PLEASE TRY AGAIN!";
                echo "<meta http-equiv='refresh' content='3; url=../newPost.php'>";
            }
            
        } else {

            $sqlCreatePost = "UPDATE post_review 
                              SET readerID = '$readerId',
                              bookID = '$bookCode',
                              ownerOpinion = '$opinion',
                              ownerRating = '$review',
                              statusPhone = '$statusPhone',
                              author = '$author',
                              genre = '$genre'
                              WHERE postCode = '$postCode'";
            $runSqlCreatePost = $conn->query($sqlCreatePost); 

            if ($runSqlCreatePost) {

                foreach ($thread as $threadData) {
                    $data = trim($threadData);
                    $sqlThreadCheck = "SELECT * FROM Thread WHERE thread LIKE '$data'";
                    $resultCheckThread = $conn->query($sqlThreadCheck); 
                    $threadData = $resultCheckThread->fetch_assoc();
                    $threadChoose = $threadData['threadID'];

                    $sqlLinkThread = "INSERT INTO Thread_Post (postCode, threadID) VALUES ('$postCode','$threadChoose')";
                    $resultLinkThread = $conn->query($sqlLinkThread);            
                }

                echo "POST UPDATED SUCCESSFULLY!";
                echo "<meta http-equiv='refresh' content='3; url=../mainmyposts.php'>";
            } else {
                echo "FAILED TO UPDATE POST! PLEASE TRY AGAIN!";
                echo "<meta http-equiv='refresh' content='3; url=../newPost.php'>";
            }
            
        }
    }

    ?>

    </main>

<?php include("../footer.html"); ?>

</body>
</html>