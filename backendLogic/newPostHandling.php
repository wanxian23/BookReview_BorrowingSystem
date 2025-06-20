<?php

session_start();
require("../database/database.php");

$readerId = $_SESSION['readerID'];

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $bookTitle = $_POST['book_title'];
    $genre = $_POST['genre'];
    $opinion = $_POST['your_opinion'];
    $author = $_POST['author'];
    $review = $_POST['review'];
    $thread = $_POST['removeThread'];

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
    foreach ($thread as $data) {
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

    if (isset($_POST['available_for_borrow'])) { 
        
        if (isset($_FILES['front_cover']) && $_FILES['front_cover']['error'] == 0) {
            $bookUploads = "bookUploads/";
            if (!is_dir($bookUploads)) mkdir($bookUploads, "0755", true);

            $frontCoverPath = $bookUploads . uniqid("img_") . "_" . basename($_FILES['front_cover']['name']);

            move_uploaded_file($_FILES['front_cover']['tmp_name'], "../".$frontCoverPath);
        }

        if (isset($_FILES['back_cover']) && $_FILES['back_cover']['error'] == 0) {
            $bookUploads = "bookUploads/";
            if (!is_dir($bookUploads)) mkdir($bookUploads, "0755", true);

            $backCoverPath = $bookUploads . uniqid("img_") . "_" . basename($_FILES['back_cover']['name']);

            move_uploaded_file($_FILES['back_cover']['tmp_name'], "../".$backCoverPath);
        }

        $synopsis = mysqli_real_escape_string($conn, $_POST['synopsis']);
        
        $sqlCreatePost = "INSERT INTO post_review (readerID, bookID, ownerOpinion, ownerRating, frontCover_img, backCover_img, synopsis, statusPhone)
        VALUES ('$readerId', '$bookCode', '$opinion','$review','$frontCoverPath','$backCoverPath','$synopsis','$statusPhone')";
        $runSqlCreatePost = $conn->query($sqlCreatePost);

        if ($runSqlCreatePost) {
            // Return the most latest post
            $sqlGetPost = "SELECT * FROM post_review WHERE readerID = '$readerId' ORDER BY postCode DESC LIMIT 1;";
            $resultGetPost = $conn->query($sqlGetPost);
            $post = $resultGetPost->fetch_assoc();
            $postCode = $post['postCode'];

            foreach ($thread as $data) {
                $sqlThreadCheck = "SELECT * FROM Thread WHERE thread LIKE '$data'";
                $resultCheckThread = $conn->query($sqlThreadCheck); 
                $threadData = $resultCheckThread->fetch_assoc();
                $threadChoose = $threadData['threadID'];

                $sqlLinkThread = "INSERT INTO Thread_Post (postCode, threadID) VALUES ('$postCode','$threadChoose')";
                $resultLinkThread = $conn->query($sqlLinkThread);            
            }

            echo "POST CREATED SUCCESSFULLY!";
            echo "<meta http-equiv='refresh' content='3; url=../mainmyposts.php'>";
        } else {
            echo "FAILED TO CREATE POST! PLEASE TRY AGAIN!";
            echo "<meta http-equiv='refresh' content='3; url=../newPost.php'>";
        }
    } else {

        $sqlCreatePost = "INSERT INTO post_review (readerID, bookID, ownerOpinion, ownerRating, statusPhone)
        VALUES ('$readerId', '$bookCode', '$opinion','$review','$statusPhone')";
        $runSqlCreatePost = $conn->query($sqlCreatePost);

        if ($runSqlCreatePost) {
            // Return the most latest post
            $sqlGetPost = "SELECT * FROM post_review WHERE readerID = '$readerId' ORDER BY postCode DESC LIMIT 1;";
            $resultGetPost = $conn->query($sqlGetPost);
            $post = $resultGetPost->fetch_assoc();
            $postCode = $post['postCode'];

            foreach ($thread as $data) {
                $sqlThreadCheck = "SELECT * FROM Thread WHERE thread LIKE '$data'";
                $resultCheckThread = $conn->query($sqlThreadCheck); 
                $threadData = $resultCheckThread->fetch_assoc();
                $threadChoose = $threadData['threadID'];

                $sqlLinkThread = "INSERT INTO Thread_Post (postCode, threadID) VALUES ('$postCode','$threadChoose')";
                $resultLinkThread = $conn->query($sqlLinkThread);            
            }

            echo "POST CREATED SUCCESSFULLY!";
            echo "<meta http-equiv='refresh' content='3; url=../mainmyposts.php'>";
        } else {
            echo "FAILED TO CREATE POST! PLEASE TRY AGAIN!";
            echo "<meta http-equiv='refresh' content='3; url=../newPost.php'>";
        }

    }
}

?>