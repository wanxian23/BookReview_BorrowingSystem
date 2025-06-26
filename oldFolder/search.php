<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

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
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <?php include("headDetails.html"); ?>

    <title>Search Result</title>

    <style>
    :root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: #a9a1ee;
            --buttonFontColor: black;
            --buttonHoverColor: #d8d5ec;

            --postHeaderBgColor: rgb(220, 196, 238);
            --postBgColor: white;

            --bookBoxShadow: 1px 1px 10px 3px rgba(0, 0, 0, 0.225);

            --anchorColor: rgb(65, 116, 227);
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;

            --postHeaderBgColor: white;
            --postBgColor: white;

            --bookBoxShadow: 1px 1px 10px 3px rgba(0, 0, 0, 0.225);

            --anchorColor: rgb(65, 116, 227);
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(40, 39, 39);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;

            --postHeaderBgColor: rgb(1, 1, 1);
            --postBgColor: rgb(45, 45, 45);

            --bookBoxShadow: 1px 1px 10px 3px rgba(237, 237, 237, 0.225);

            --anchorColor: rgb(149, 178, 241);
        }

        main {
            padding: 50px 20px;
        }

        article {
            margin: 0px auto;
            max-width: 1250px;
            padding: 20px;
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            box-shadow: var(--containerBoxShadow);
            border-radius: 10px;
            border: 2px solid var(--borderColor);
            font-size: 1em;
        }

        .header-row {
            display: flex;
            align-items: center;
            gap: 33%;
            padding: 5px 0;
            margin-bottom: 20px;
        }

        .header-line {
            border-top: 1px solid #848484;
            margin-bottom: 20px;
        }

        .back-button {
            font-size: 1.1em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
            display: none; /* Hidden as per the image layout */
        }

        i {
            font-size: 1.5em;
            color: var(--containerColor);
        }

        h1 {
            margin: 0;
            font-size: 1.3em;
            font-weight: bold;
            text-align: center;
            width: 100%;
        }

        .book-posts-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr; 
            gap: 30px;
            max-height: 430px; 
            overflow-y: auto;
            padding-right: 15px;
            box-sizing: border-box;
        }

        
        .book-posts-wrapper::-webkit-scrollbar {
            width: 12px; 
        }

        .book-posts-wrapper::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .book-posts-wrapper::-webkit-scrollbar-thumb {
            background: #888; 
            border-radius: 10px;
        }

        .book-posts-wrapper::-webkit-scrollbar-thumb:hover {
            background: #555; 
        }

        
        .book-posts-wrapper {
            scrollbar-width: thin; 
            scrollbar-color: #888 #f1f1f1; 
        }

        .book-post {
            border: 1px solid var(--borderColor);
            border-radius: 9px;
            background-color: var(--contentBgColor);
            color: var(--containerColor);
            overflow: hidden; 
            display: flex;
            flex-direction: column;
            min-height: 280px;
    
        }

        .book-post-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-bottom: 1px solid var(--borderColor);
            background-color: var(--postHeaderBgColor); /* Add this line */
        }

        .book-post-header .icon {
            text-decoration: none;
            background-color: #a0c0e0;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
            font-weight: bold;
            border: 3px solid;           
        }

        .book-post-header img {
            background-color: #a0c0e0;
            color: white;
            border-radius: 50%;
            width: 25px;
            height: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9em;
            font-weight: bold;
            border: 3px solid;        
        }

        .book-post-header .title {
            font-weight: bold;
        }

        .book-post-content {
            display: flex;
            padding: 15px;
            gap: 15px;
            flex-grow: 1;
        }

        .book-post-image img {
            width: 90px;
            height: 130px;
            border: 1px solid #000;
            flex-shrink: 0;
        }

        .book-details {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .book-details .book-title-display {
            font-size: 1.1em;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .book-details .book-review-score,
        .book-details .book-genre {
            font-size: 0.9em;
            margin-bottom: 5px;
        }

        .book-details .description {
            font-size: 0.85em;
            line-height: 1.4;
            flex-grow: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 10px;
        }

        .book-details .read-more {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
            font-size: 0.85em;
            align-self: flex-start;
        }

        .book-post-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border-top: 1px solid var(--borderColor);
            flex-shrink: 0;
        }

        .book-post-footer .comment-box {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            flex-grow: 1;
            margin-right: 10px;
        }

        .book-post-footer .comment-box i {
            margin-right: 5px;
            color: #888;
        }

        .book-post-footer .comment-box input {
            border: none;
            background: transparent;
            width: 100%;
            outline: none;
            color: var(--containerColor);
        }

        .book-post-footer .average-review {
            font-weight: bold;
            font-size: 0.9em;
        }

        hr {
            border: none;
            border-top: 1.6px solid #848484;
            margin: 0.5rem 0;
        }

        @media (max-width: 768px) {
            .book-posts-wrapper {
                grid-template-columns: 1fr; 
                max-height: 600px;
            }
            main {
                padding: 20px;
            }
            article {
                padding: 15px;
            }
            h1 {
                font-size: 1.1em;
            }
            .book-post-content {
                flex-direction: column;
                align-items: center;
            }
            .book-post-image img {
                margin-bottom: 15px;
            }
            .book-details {
                text-align: center;
                width: 100%;
            }
            .book-details .read-more {
                align-self: center;
            }
        }

        div.post {
            margin: 0 25px 15px 25px;
            border: 2px solid var(--containerColor);
            border-radius: 15px;
            width: 95%;
            background-color: var(--postBgColor);
            height: 320px;
        }


    div.head {
            border-bottom: 2px solid;
            padding: 15px;
            background-color: var(--postHeaderBgColor);
            border-radius: 15px 15px 0 0;
        }

    div.post div.head div.postProfile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

    div.post div.head div.postProfile img {
        display: inline-block;
        border-radius: 40px;
        height: 100%;
        width: 100%;    
    }

    div.post div.head div.postProfile a {
            display: inline-flex;
            text-decoration: none;
            border-radius: 40px;
            height: 40px;
            width: 40px;
            border: 4px solid var(--containerColor);
            background-color: rgb(202, 28, 57);
            align-items: center;
            justify-content: center;
            color: black;
        }

    div.post div.body {
            display: flex;
            border-bottom: 2px solid;
            height: 200px;
        }

    div.post div.body div.left {
            border-right: 2px solid;
            width: 70%;
        }

    div.post div.body div.right {
            padding: 20px;
            width: 30%;
            display: flex;
            justify-content: center;
        }

    div.post div.body div.right img {
            width: 80%;
            height: 100%;
            box-shadow: var(--bookBoxShadow);
        }

    div.post div.body div.left div.review {
            padding: 15px;
            border-bottom: 2px solid;
        }

    div.post div.body div.left div.review h3 {
            display: flex;
            justify-content: space-between;
        }

    div.post div.body div.left div.description {
            overflow-wrap: anywhere;
            padding: 15px;
        }

    div.post div.body div.left div.description p a {
            text-decoration: none;
            color: var(--anchorColor);
        }

    div.post div.body div.left div.review section.postContainer article:nth-of-type(2) div.post div.bottom {
            padding: 10px;
        }

    div.post div.bottom {
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

    div.post div.bottom h3 {
            font-size: 0.8em;
        }


    div.post div.bottom div.left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

    div.post div.bottom input {
            width: 70%;
            font-size: 0.7em;
            border-radius: 5px;
            padding: 5px;
            border: 1px solid var(--postHeaderBgColor);
            transition: 0.3s;
        }

    div.post div.bottom input:active {
            border: 1px solid black;
        }
    </style>

</head>

<body>

    <?php include("header.php"); ?>

    <main>
        <article>

            <?php

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (!empty($_POST['search'])) {

            $search = trim($_POST['search']);

            $sqlGetPostDetails = "SELECT 
                    post.*,
                    reader.*,
                    book.*,
                    thread.*
                FROM post_review post
                INNER JOIN reader_user reader USING (readerID)
                INNER JOIN book_record book USING (bookID)
                LEFT JOIN thread_post threadPost USING (postCode)
                LEFT JOIN thread thread USING (threadID)
                WHERE book.bookTitle LIKE '%$search%'
                OR thread.thread LIKE '%$search%'
                GROUP BY post.postCode";
            $resultGetPostDetails = $conn->query($sqlGetPostDetails);
            $post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);

            echo '<div class="header-row">';
            echo '    <div class="back-button"><i class="bx bx-reply"></i> Back</div>';
            echo '    <h1>Result post based on search &quot;' . htmlspecialchars($search) . '&quot;</h1>';
            echo '</div>';
            echo '<hr class="header-line">';
            echo '<div class="book-posts-wrapper">';

            foreach ($post as $row) {

                $sqlGetComment = "SELECT
                    comment.*,
                    post.*,
                    reader.*,
                    bookBorrow.*
                FROM Comment_Rating comment
                INNER JOIN Post_Review post ON comment.postCode = post.postCode
                INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
                INNER JOIN book_borrowed bookBorrow ON comment.bookBorrowCode = bookBorrow.bookBorrowCode
                WHERE comment.postCode = '{$row['postCode']}'";
                $resultGetComemnt = $conn->query($sqlGetComment);
                $comment = $resultGetComemnt->fetch_all(MYSQLI_ASSOC);

                $averageRating = 0;
                if (!empty($comment)) {

                        $i = 0;
                        foreach($comment as $commentData) {

                            if ($commentData['bookBorrowCode'] != null) {
                                $averageRating += $commentData['ratingFeedback'];
                                $i++;
                            }

                        }
                        
                        if ($i != 0) {
                            $averageRating = $averageRating / $i;
                        }

                }

                echo '<div class="post">';
                echo '    <div class="head">';
                echo '        <div class="postProfile">';
                
                $profileLink = "viewUsersProfile.php?readerID=" . $row['readerID'];
                if ($row['readerID'] != $readerID) {
                    if ($row['avatar'] != null) {
                        echo '            <a href="'.$profileLink.'"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
                    } else {
                        echo '            <a href="'.$profileLink.'">'.$row['username'][0].'</a>';                               
                    }
                } else {
                    if ($row['avatar'] != null) {
                        echo '            <a href="profilemyposts.php"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
                    } else {
                        echo '            <a href="profilemyposts.php">'.$row['username'][0].'</a>';                               
                    }
                }
                echo $row['username'];
                echo '        </div>';
                echo '    </div>';
                echo '    <div class="body">';
                echo '        <div class="left">';
                echo '            <div class="review">';
                echo '                <h2>Book Title: '.$row['bookTitle']. '</h2>';
                echo '                <h3><label for="">Review: '.$row['ownerRating'].'/10</label><label for="">Genre: '.$row['genre'].'</label></h3>';
                echo '            </div>';
                echo '            <div class="description">';
                echo '                <p>';
                echo substr($row['ownerOpinion'], 0, 240);
                echo '                    <a href="bookDetail.php?postCode='.$row['postCode'].'">... Read More</a>';
                echo '                </p>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="right">';
                if ($row['frontCover_img'] != null) {
                    echo '            <img src="'.$row['frontCover_img'].'" alt="Book Cover">';
                }  else {
                    echo '            <img src="bookUploads/noImageUploaded.png" alt="Book Cover">';
                }
                echo '        </div>';
                echo '    </div>';
                echo '    <div class="bottom">';
                echo '        <div class="left">';
                echo '        </div>';
                if ($averageRating != 0) {
                    echo '<h3>Average Review: '.number_format($averageRating, 1).'</h3>';
                } else {
                    echo '<h3>Average Review: No Rating</h3>';
                }
                echo '    </div>';
                echo '</div>';
            } 

            echo '</div>';
            
        } else {
            echo '<div class="book-posts-wrapper" style="grid-template-columns: 1fr;">';
            echo "<label style='text-align: center;'>No Search Result Found</label>";
            echo '</div>';
        }

    } else if (isset($_REQUEST['thread'])) {

        $thread = $_REQUEST['thread'];

            $sqlGetPostDetails = "SELECT 
                post.*,
                reader.*,
                book.*,
                thread.*
            FROM post_review post
            INNER JOIN reader_user reader USING (readerID)
            INNER JOIN book_record book USING (bookID)
            INNER JOIN thread_post threadPost USING (postCode)
            INNER JOIN thread thread USING (threadID)
            WHERE thread.thread ='$thread'
            GROUP BY post.postCode";
        $resultGetPostDetails = $conn->query($sqlGetPostDetails);
        $post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);

        if ($resultGetPostDetails->num_rows > 0) {
            echo '<div class="header-row">';
            echo '    <div class="back-button"><i class="bx bx-reply"></i> Back</div>';
            echo '    <h1>Result post based on thread &quot;' . htmlspecialchars($thread) . '&quot;</h1>';
            echo '</div>';
            echo '<hr class="header-line">';
            echo '<div class="book-posts-wrapper">';

            foreach ($post as $row) {

                $sqlGetComment = "SELECT
                    comment.*,
                    post.*,
                    reader.*,
                    bookBorrow.*
                FROM Comment_Rating comment
                INNER JOIN Post_Review post ON comment.postCode = post.postCode
                INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
                INNER JOIN book_borrowed bookBorrow ON comment.bookBorrowCode = bookBorrow.bookBorrowCode
                WHERE comment.postCode = '{$row['postCode']}'";
                $resultGetComemnt = $conn->query($sqlGetComment);
                $comment = $resultGetComemnt->fetch_all(MYSQLI_ASSOC);

                $averageRating = 0;
                if (!empty($comment)) {

                        $i = 0;
                        foreach($comment as $commentData) {

                            if ($commentData['bookBorrowCode'] != null) {
                                $averageRating += $commentData['ratingFeedback'];
                                $i++;
                            }

                        }
                        
                        if ($i != 0) {
                            $averageRating = $averageRating / $i;
                        }

                }

                echo '<div class="post">';
                echo '    <div class="head">';
                echo '        <div class="postProfile">';
                $profileLink = "viewUsersProfile.php?readerID=" . $row['readerID'];
                if ($row['readerID'] != $readerID) {
                    if ($row['avatar'] != null) {
                        echo '            <a href="'.$profileLink.'"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
                    } else {
                        echo '            <a href="'.$profileLink.'">'.$row['username'][0].'</a>';                               
                    }
                } else {
                    if ($row['avatar'] != null) {
                        echo '            <a href="profilemyposts.php"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
                    } else {
                        echo '            <a href="profilemyposts.php">'.$row['username'][0].'</a>';                               
                    }
                }
                echo $row['username'];
                echo '        </div>';
                echo '    </div>';
                echo '    <div class="body">';
                echo '        <div class="left">';
                echo '            <div class="review">';
                echo '                <h2>Book Title: '.$row['bookTitle']. '</h2>';
                echo '                <h3><label for="">Review: '.$row['ownerRating'].'/10</label><label for="">Genre: '.$row['genre'].'</label></h3>';
                echo '            </div>';
                echo '            <div class="description">';
                echo '                <p>';
                echo substr($row['ownerOpinion'], 0, 240);
                echo '                    <a href="bookDetail.php?postCode='.$row['postCode'].'">... Read More</a>';
                echo '                </p>';
                echo '            </div>';
                echo '        </div>';
                echo '        <div class="right">';
                if ($row['frontCover_img'] != null) {
                    echo '            <img src="'.$row['frontCover_img'].'" alt="Book Cover">';
                }  else {
                    echo '            <img src="bookUploads/noImageUploaded.png" alt="Book Cover">';
                }
                echo '        </div>';
                echo '    </div>';
                echo '    <div class="bottom">';
                echo '        <div class="left">';
                echo '        </div>';
                if ($averageRating != 0) {
                    echo '<h3>Average Review: '.number_format($averageRating, 1).'</h3>';
                } else {
                    echo '<h3>Average Review: No Rating</h3>';
                }
                echo '    </div>';
                echo '</div>';

            } 

            echo '</div>';
        } else {
            echo '<div class="book-posts-wrapper" style="grid-template-columns: 1fr;">';
            echo "<label style='text-align: center;'>No Post Result Found Based on Thread</label>";
            echo '</div>';          
        }

    }

            ?>
        </article>
    </main>

    <?php include("footer.html"); ?>

</body>

</html>