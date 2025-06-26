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

$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      WHERE post.readerID = '$readerID'
                      ORDER BY post.postCode DESC";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

    <?php include("headDetails.html"); ?>
    <title>BookSpare - Search Results</title>

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
        padding: 20px 100px;
        margin: 2% auto;
    }

    .search-results-header {
        background: transparent;
        border-radius: 0;
        padding: 0 0 10px 0;
        margin-bottom: 10px;
        font-weight: bold;
        font-size: 16px;
        color: #333;
        margin-top: 10px;
    }

.my-posts-header {
        padding: 15px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: sticky;
        min-height: 50px;
        position: relative;
        border-bottom: 2px solid black;
    }
    
    .back-button {
        position: absolute;
        left: 20px;
        font-size: 1.3em;
        font-weight: bold;
        color: var(--containerColor);;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .my-posts-title {
        font-size: 24px;
        font-weight: bold;
        color: var(--containerColor);;
        text-align: center;
        flex-grow: 1;
        margin-right: 60px;
    }

    .my-posts-header::after {
        content: '';
        display: block;
        margin-top: 10px;
        margin-left: -20px;
        margin-right: -20px;
        padding: 0 20px;
    }


.result-post{
    border-bottom: 2px solid black;
}


    .results-container {
        background-color: var(--containerBgColor);
        box-shadow: var(--bookBoxShadow);
        border: 2px solid var(--containerColor);
        color: var(--containerColor);
        border-radius: 15px;
        padding: 20px;
        height: 860px;
    }

    .results-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
        margin-top: 30px;
        overflow-y: scroll;
        padding: 15px;
        height: 86%;
    }

    @media (max-width: 768px) {
        .results-grid {
            grid-template-columns: 1fr;
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
        <div class="results-container">
            <div class="my-posts-header">
                <a class="back-button" onclick="window.history.back()">
                <div class="back-button"><i class='bx bx-reply'></i>Back</div>
                </a>
                <span class="my-posts-title">My Posts</span>
            </div>

            <div class="results-grid">

                <?php

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
                        if ($row['avatar'] != null) {
                            echo '            <a href="profilemyposts.php"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
                        } else {
                            echo '            <a href="">A</a>';                               
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
                        echo substr($row['ownerOpinion'], 0, 260);
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

                ?>

            </div>
        </div>
    </main>

    <?php include("footer.html"); ?>

    <script>
        // Add some interactivity
        document.querySelectorAll('.read-more').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Read more functionality would expand the review text');
            });
        });

        document.querySelectorAll('.comment-input').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    alert('Comment functionality would post the comment');
                    this.value = '';
                }
            });
        });
    </script>
</body>

</html>