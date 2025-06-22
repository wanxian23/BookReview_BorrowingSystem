<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$username' OR phone = '$username'";
$runSQL = $conn->query(query: $sql);
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

$sqlGetThreads = "SELECT
                    thread.*
                  FROM Thread_Post threadPost
                  INNER JOIN Thread thread USING (threadID)
                  INNER JOIN Post_Review post USING (postCode)
                  WHERE threadPost.postCode = '$postCode'";
$resultGetThreads = $conn->query($sqlGetThreads);
$thread = $resultGetThreads->fetch_all(MYSQLI_ASSOC);

$sqlGetComment = "SELECT
                    comment.*,
                    post.*,
                    reader.*
                  FROM Comment_Rating comment
                  INNER JOIN Post_Review post ON comment.postCode = post.postCode
                  INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
                  WHERE comment.postCode = '$postCode'";
$resultGetComemnt = $conn->query($sqlGetComment);
$comment = $resultGetComemnt->fetch_all(MYSQLI_ASSOC);


?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <?php include("headDetails.html"); ?>

    <title>Book Details Page</title>

    <style>
        :root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(34, 34, 34);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
            --contentBgColor: rgb(53, 53, 53);
            --borderColor: white;
        }

        main {
            padding: 50px 50px;
        }

        article {
            margin: 0px auto;
            max-width: 960px;
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
        }

        .header-line {
            border-top: 1px solid #848484;
        }

        .back-button {
            font-size: 1.1em;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.3rem;
            cursor: pointer;
        }

        i {
            font-size: 1.5em;
            color: var(--containerColor);
        }

        h1 {
            margin: 0;
            font-size: 1.3em;
            font-weight: bold;
        }

        .book-container {
            display: flex;
            flex-direction: column;
            border: 1px solid var(--borderColor);
            border-radius: 9px;
            background-color: var(--contentBgColor);
            color: var(--containerColor);
            margin: 30px;
            overflow: hidden;
        }

        .top-row {
            display: flex;
            height: 230px;
            border-bottom: 1px solid;
        }

        .book-image img {
            width: 120px;
            height: 170px;
            border: 1px solid #000;
            flex-shrink: 0;
        }

        .book-image-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            padding: 10px 20px;
            width: 220px;
        }

        .arrow-icon {
            font-size: 1em;
            color: var(--containerColor);
            cursor: pointer;
        }

        .book-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-wrap: break-word;
            word-wrap: break-word;
        }

        .bookTitleReview {
            padding: 15px;
            border-bottom: 1px solid;
            line-height: 25px;
        }

        .arrow-icon {
            font-size: 1.8rem;
            color: #000;
            display: block;
            margin-top: 0.3rem;
            text-align: center;
        }

        .vertical-line {
            width: 1.6px;
            background-color: #848484;
        }

        .book-details .button-box {
            display: flex;
            flex: 1;
            display: flex;
            flex-direction: row;
            justify-content: left;
        }

        .book-title {
            font-size: 1.3em;
            font-weight: bold;
        }

        .book-rating {
            float: inline-end;
            font-size: 1.9rem;
            font-weight: bold;
        }

        .book-author,
        .book-genre {
            font-size: 1em;
            align-self: flex-end;
        }

        .button-box {
            border-radius: 5px;
            padding: 5px 15px;
            font-size: 1em;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            line-height: 1.4;
            word-break: break-word;
            height: 120px;
        }

        .synopsis-box {
            padding: 20px;
            font-size: 1em;
            word-break: break-word;
            width: 100%;
            border-bottom: 1px solid;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .synopsis-box h2 {
            font-size: 1.2em;
        }

        .thread-box {
            padding: 20px;
            font-size: 1em;
            word-break: break-word;
            width: 100%;
            border-bottom: 1px solid;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: left;
        }

        .thread-box label {
            padding: 5px 20px;
            background-color: lightgray;
            border-radius: 8px;
            box-shadow: 1px 3px 3px rgb(184, 184, 184);
        }

        .book-review {
            padding: 20px;
            font-size: 1em;
            word-break: break-word;
            width: 100%;
            border-bottom: 1px solid;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .book-review label {
            display: flex;
            gap: 10px;
        }

        .comment-box {
            padding: 20px;
            font-size: 1em;
            word-break: break-word;
            width: 100%;
            border-bottom: 1px solid;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .comment-box form {
            display: flex;
            gap: 10px;
            width: 100%;
            flex-direction: column;
        }
        
        .comment-box form div.inputContainer {
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: space-between;
        }

        .comment-box form div.inputContainer div {
            display: flex;
            gap: 12px;    
            width: 100%;  
        }

        .comment-box textarea, .comment-box input[type="number"] {
            min-height: 30px;
            border-radius: 6px;
            padding: 3px 10px;
            resize: vertical;
            overflow: auto; 
            width: 70%;  
        }

        .comment-box input[type="submit"] {
            padding: 8px 15px;
            border-radius: 6px;
            background-color: #a9a1ee;
            transition: 0.2s;
        }

        .comment-box input[type="submit"]:hover {
            background-color: rgb(198, 194, 238);
        }

        hr {
            border: none;
            border-top: 1.6px solid #848484;
            margin: 0.5rem 0;
        }

        .viewComment-box {
            border-radius: 5px;
            padding: 0 20px;
            font-size: 1em;
            word-break: break-word;
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 20px
        }

        .viewComment-box .commentOption {
            display: flex;
            gap: 20px;
            padding: 20px;
            border-bottom: 1px solid;
        }

        .viewComment-box .commentOption input, 
        .viewComment-box .commentOption button {
            text-decoration: none;
            padding: 10px 20px;
            background-color: #a9a1ee;
            border-radius: 10px;
            border: 2px solid;
            transition: 0.2s;
        }

        .viewComment-box .commentOption input:hover,
        .viewComment-box .commentOption button:hover {
            text-decoration: none;
            padding: 10px 20px;
            background-color:rgb(198, 194, 238);
            border-radius: 10px;
        }
        
        .viewComment-box .commentOption .active,
        .viewComment-box .commentOption .active {
            font-weight: bold;
            border-bottom: 5px solid;
        }

        .viewComment-box .commentContainer {
            border-bottom: 1px solid;
            padding: 0 20px 20px 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .viewComment-box .commentContainer:last-child {
            margin-bottom: 20px;
        }

        .viewComment-box div.postProfile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .viewComment-box div.postProfile img {
            display: inline-block;
            border-radius: 40px;
            height: 100%;
            width: 100%;    
        }

        .viewComment-box div.postProfile a {
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

        .viewComment-box div.postProfile label {
            font-size: 1.4em;
        }

        .viewComment-box .commentContent {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .viewComment-box .commentContent label:nth-child(2) {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        @media (max-width: 700px) {

            .header-row {
                gap: 7%;
            }

            .top-row {
                flex-direction: column;
            }

            .book-image-wrapper {
                width: 100%;
            }

            .book-image-wrapper {
                justify-content: center;
                padding: 30px;
            }

            .top-row {
                height: 500px;
            }

            .bookTitleReview {
                border-top: 1px solid;
            }
        }
    </style>

    <script>
        $(document).ready(function () {
            $(".back-button").click(function () {
                window.history.back();
            });
        });
    </script>
</head>

<body>
    
<?php include("header.php"); ?>

    <main>
        <article>

            <div class="header-row">
                <div class="back-button"><i class='bx bx-reply'></i>Back</div>
                <h1>Detail of the Book</h1>
            </div>

            <hr class="header-line">

            <div class="book-container">

            <?php
            
                if ($post['frontCover_img'] != null) {
                    echo '<div class="top-row">';
                    echo '    <div class="book-image-wrapper">';
                    echo '        <div class="book-image">';
                    echo '            <img src="'.$post['frontCover_img'].'" alt="Book Cover">';
                    echo '        </div>';
                    echo '        <div class="arrow-icon">';
                    echo '            <i class="bx bx-caret-right"></i>';
                    echo '        </div>';
                    echo '    </div>';
    
                    echo '    <div class="vertical-line"></div>';
    
                    echo '    <div class="book-content">';
                    echo '        <div class="bookTitleReview">';
                    echo '            <span class="book-title">Book Title: '.$post['bookTitle'].'</span>';
                    echo '            <span class="book-rating">'.$post['ownerRating'].'/10</span><br>';
                    echo '            <span class="book-author">Author: '.$post['author'].'</span><br>';
                    echo '            <span class="book-genre">Genre: '.$post['genre'].'</span>';
                    echo '        </div>';
                    echo '        <div class="button-box">';
                    if ($post['statusPhone'] == "YES") {
                        echo "<label>Please Contact My Whatsapp Or Call Me If You Wanna Borrow This Book</label>";
                        echo "<label>My Contact Number: <a href='https://wa.me/6{$post['phone']}' target='_blank'>{$post['phone']}</a></label>";
                    } else {
                        echo "<label>Book Owner Did Not Public His/ Her Contact Number. Therefore This Book Is Not Available For Borrow Currently!<label>";
                    }
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';
   
                    echo '<div class="synopsis-box">';
                    echo '<h2>Opinion Of The Book</h2>';
                    echo $post['ownerOpinion'];
                    echo '</div>';

                    echo '<div class="synopsis-box">';
                    echo '<h2>Synopsis Of The Book</h2>';
                    echo $post['synopsis'];
                    echo '</div>';

                    echo '<div class="thread-box">';
                    if (!empty($thread)) {
                        foreach ($thread as $data) {
                            echo "<label>{$data['thread']}</label>";
                        }
                    } else {
                        echo "No Thread Listed...";
                    }
                    echo '</div>';

                    echo '<div class="comment-box">';
                    echo '<form id="commentForm" method="POST" action="' . htmlspecialchars("backendLogic/commentHandling.php?postCode=" . $postCode) . '">';
                    echo '<div class="inputContainer">';
                    echo '<div>';
                    echo '<box-icon name="message-minus" id="burgerIcon" size="10"></box-icon>';
                    echo '<textarea name="comment" id="comment" placeholder="Comment"></textarea>';
                    echo '</div>';
                    echo '<input type="submit" name="addComment" value="Add Comment">';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';

                    echo '<div class="viewComment-box">';
                    echo '<form class="commentOption" method="GET" action="bookDetail.php">';
                    echo '    <input type="hidden" name="postCode" value="' . $postCode . '">';
                    $userActive = (!isset($_GET['section']) || $_GET['section'] === 'user') ? 'active' : '';
                    $borrowerActive = (isset($_GET['section']) && $_GET['section'] === 'borrower') ? 'active' : '';
                    
                    echo '    <button type="submit" name="section" value="user" class="' . $userActive . '" id="userCommentBt">User Comment</button>';
                    echo '    <button type="submit" name="section" value="borrower" class="' . $borrowerActive . '" id="borrowerRatingBt">Borrower Comment & Rating</button>';
                    
                    echo '</form>';                    
                    if (isset($_GET['section'])) {
                        if ($_GET['section'] === 'user') {
                            include 'bookDetailsSection/commentSection.php';
                        } elseif ($_GET['section'] === 'borrower') {
                            include 'bookDetailsSection/ratingSection.php';
                        }
                    } else {
                        include 'bookDetailsSection/commentSection.php'; // default section
                    }
                    echo '</div>';
                } else {
                    echo '<div class="top-row">';
                    echo '    <div class="book-image-wrapper" style="justify-content: center;">';
                    echo '        <div class="book-image">';
                    echo '            <img src="bookUploads/noImageUploaded.png" alt="Book Cover">';
                    echo '        </div>';
                    echo '    </div>';
                    echo '    <div class="vertical-line"></div>';
                    echo '    <div class="book-content">';
                    echo '        <div class="bookTitleReview">';
                    echo '            <span class="book-title">Book Title: '.$post['bookTitle'].'</span>';
                    echo '            <span class="book-rating">'.$post['ownerRating'].'/10</span><br>';
                    echo '            <span class="book-author">Author: '.$post['author'].'</span><br>';
                    echo '            <span class="book-genre">Genre: '.$post['genre'].'</span>';
                    echo '        </div>';
                    echo '        <div class="button-box">';
                    if ($post['statusPhone'] == "YES") {
                        echo "<label>Please Contact My Whatsapp Or Call Me If You Wanna Borrow This Book</label>";
                        echo "<label>My Contact Number: <a href='https://wa.me/6{$post['phone']}' target='_blank' >{$post['phone']}</a></label>";
                    } else {
                        echo "<label>Book Owner Did Not Public His/ Her Contact Number. Therefore This Book Is Not Available For Borrow Currently!<label>";
                    }
                    echo '        </div>';
                    echo '    </div>';
                    echo '</div>';

                    echo '<div class="synopsis-box">';
                    echo '<h2>Opinion Of The Book</h2>';
                    echo $post['ownerOpinion'];
                    echo '</div>';
    
                    echo '<div class="synopsis-box">';
                    echo '<h2>Synopsis Of The Book</h2>';
                    echo 'No Synopsis Here...';
                    echo '</div>';

                    echo '<div class="thread-box">';
                    if (!empty($thread)) {
                        foreach ($thread as $data) {
                            echo "<label>{$data['thread']}</label>";
                        }
                    } else {
                        echo "No Thread Listed...";
                    }
                    echo '</div>';

                    echo '<div class="comment-box">';
                    echo '<form id="commentForm" method="POST" action="' . htmlspecialchars("backendLogic/commentHandling.php?postCode=" . $postCode) . '">';
                    echo '<div class="inputContainer">';
                    echo '<div>';
                    echo '<box-icon name="message-minus" id="burgerIcon" size="10"></box-icon>';
                    echo '<textarea name="comment" id="comment" placeholder="Comment"></textarea>';
                    echo '</div>';
                    echo '<input type="submit" name="addComment" value="Add Comment">';
                    echo '</div>';
                    echo '</form>';
                    echo '</div>';

                    echo '<div class="viewComment-box">';
                    echo '<form class="commentOption" method="GET" action="bookDetail.php">';
                    echo '    <input type="hidden" name="postCode" value="' . $postCode . '">';
                    $userActive = (!isset($_GET['section']) || $_GET['section'] === 'user') ? 'active' : '';
                    $borrowerActive = (isset($_GET['section']) && $_GET['section'] === 'borrower') ? 'active' : '';
                    
                    echo '    <button type="submit" name="section" value="user" class="' . $userActive . '" id="userCommentBt">User Comment</button>';
                    echo '    <button type="submit" name="section" value="borrower" class="' . $borrowerActive . '" id="borrowerRatingBt">Borrower Comment & Rating</button>';
                    
                    echo '</form>';                    
                    if (isset($_GET['section'])) {
                        if ($_GET['section'] === 'user') {
                            include 'bookDetailsSection/commentSection.php';
                        } elseif ($_GET['section'] === 'borrower') {
                            include 'bookDetailsSection/ratingSection.php';
                        }
                    } else {
                        include 'bookDetailsSection/commentSection.php'; // default section
                    }
                    echo '</div>';
                }

            ?>

            </div>

        </article>
    </main>

    <?php include("footer.html"); ?>

    <script>
        $(document).ready(function() {
            
            $("#commentForm").submit(function(event) {
                if (document.getElementById("comment").value === "") {
                    event.preventDefault();
                    window.alert("Comment Cannot Be Empty Before Submit!");
                    return;
                }
            });

        });
    </script>

</body>

</html>