<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$readerID = $_SESSION['readerID'];
$username = $_SESSION['username'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username' OR email = '$username' OR phone = '$username'";
$runSQL = $conn->query($sql);

$user = $runSQL->fetch_assoc();

$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.username,
                          book.bookTitle
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
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
        padding: 20px;
        max-width: 1300px;
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
        font-size: 16px;
        font-weight: bold;
        color: #333;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .my-posts-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
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
        background: white;
        border: 2px solid black;
        border-radius: 15px;
        padding: 20px;
        height: 700px;
    }

    .results-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
        margin-top: 30px;
        overflow-y: scroll;
        padding: 15px;
        height: 83%;
    }

    .review-card {
        border: 2px solid #333;
        border-radius: 15px;
        background: white;
        overflow: hidden;
        width: 100%;
        height: 350px;
        display: flex;
        flex-direction: column;
    }

    .review-header {
        background: #b19cd9;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-initial {
        width: 35px;
        height: 35px;
        background: #333;
        border-radius: 50%;
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .user-name {
        font-weight: bold;
        color: #333;
    }

    .review-content {
        display: flex;
        padding: 15px;
        gap: 15px;
        overflow-y: auto;
        flex: 1;
    }

    .review-left {
        flex: 1;
        overflow-y: auto;
    }

    .book-title {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 8px;
        color: #333;
    }

    .review-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
        color: #666;
    }

    .review-text {
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 10px;
        color: #333;
    }

    .read-more {
        color: #888;
        text-decoration: none;
        font-size: 14px;
    }

.book-image {
            width: 120px;
            height: 170px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 12px;
            text-align: center;
        }

    .comment-section {
        background: #f8f8f8;
        padding: 15px;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comment-input-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comment-icon {
        width: 20px;
        height: 20px;
    }

    .comment-input {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 20px;
        font-size: 14px;
        width: 200px;
    }

    .average-review {
        font-size: 14px;
        font-weight: bold;
        color: #333;
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
                    <box-icon name='arrow-left'></box-icon>Back
                </a>
                <span class="my-posts-title">My Posts</span>
            </div>

            <div class="results-grid">

                <?php

                    foreach ($post as $row) {

                        if ($row['frontCover_img'] != null) {
                            echo '<div class="post">';
                            echo '    <div class="head">';
                            echo '        <div class="postProfile">';
                            echo '            <a href="">A</a>';
                            echo $row['username'];
                            echo '        </div>';
                            echo '    </div>';
                            echo '    <div class="body">';
                            echo '        <div class="left">';
                            echo '            <div class="review">';
                            echo '                <h2>Book Title: '.$row['bookTitle']. '</h2>';
                            echo '                <h3><label for="">Review: '.$row['ownerRating'].'/10</label><label for="">Genre: Horror</label></h3>';
                            echo '            </div>';
                            echo '            <div class="description">';
                            echo '                <p>';
                            echo $row['ownerOpinion'];
                            echo '                    <a href="bookDetail.php?postCode='.$row['postCode'].'">... Read More</a>';
                            echo '                </p>';
                            echo '            </div>';
                            echo '        </div>';
                            echo '        <div class="right">';
                            echo '            <img src="'.$row['frontCover_img'].'" alt="Book Cover">';
                            echo '        </div>';
                            echo '    </div>';
                            echo '    <div class="bottom">';
                            echo '        <div class="left">';
                            echo '            <box-icon name="message-minus" id="burgerIcon" size="10"></box-icon>';
                            echo '            <input type="text" name="comment" id="comment" placeholder="Comment">';
                            echo '        </div>';
                            echo '        <h3>Average Review: 1.9</h3>';
                            echo '    </div>';
                            echo '</div>';
                        } else {
              
                            echo '<div class="post">';
                            echo '    <div class="head">';
                            echo '        <div class="postProfile">';
                            echo '            <a href="">A</a>';
                            echo $row['username'];
                            echo '        </div>';
                            echo '    </div>';
                            echo '    <div class="body">';
                            echo '        <div class="left">';
                            echo '            <div class="review">';
                            echo '                <h2>Book Title: '.$row['bookTitle']. '</h2>';
                            echo '                <h3><label for="">Review: '.$row['ownerRating'].'/10</label><label for="">Genre: Horror</label></h3>';
                            echo '            </div>';
                            echo '            <div class="description">';
                            echo '                <p>';
                            echo $row['ownerOpinion'];
                            echo '                    <a href="bookDetail.php?postCode='.$row['postCode'].'">... Read More</a>';
                            echo '                </p>';
                            echo '            </div>';
                            echo '        </div>';
                            echo '        <div class="right">';
                            echo '            <img src="bookUploads/noImageUploaded.png" alt="Book Cover">';
                            echo '        </div>';
                            echo '    </div>';
                            echo '    <div class="bottom">';
                            echo '        <div class="left">';
                            echo '            <box-icon name="message-minus" id="burgerIcon" size="10"></box-icon>';
                            echo '            <input type="text" name="comment" id="comment" placeholder="Comment">';
                            echo '        </div>';
                            echo '        <h3>Average Review: 1.9</h3>';
                            echo '    </div>';
                            echo '</div>';
                        }
                                                
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