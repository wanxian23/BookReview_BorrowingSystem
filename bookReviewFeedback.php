<?php

session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['bookReviewLogin'] = $_SERVER['REQUEST_URI'];  // Save current URL
    header("Location: login.php");
    exit();
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
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

    <?php include("headDetails.html"); ?>
    <title>Book Review Feedback</title>

    <style>
        :root {
            --containerBgColor: white;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;

            --headerBoxShadow: 1px 1px 30px darkblue;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: rgb(244, 244, 244);
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;

            --headerBoxShadow: 1px 1px 30px black;
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(40, 39, 39);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;

            --anchorColor: rgb(149, 178, 241);

            --headerBoxShadow: 1px 1px 30px white;
        }

        main {
            margin: 5%;
            font-family: Arial, Helvetica, sans-serif;
        }

        main label.output {
            text-align: center;
            font-size: 1.5em;
            margin: 0 auto;
            display: inline-block;
            width: 100%;
        }

        .review-container {
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            border-radius: 12px;
            padding: 30px 30px 10px 30px;
            max-width: 1000px;
            width: 100%;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin: 0 auto;
            box-shadow: var(--containerBoxShadow);
        }

        .review-container p {
            margin-bottom: 30px;
        }

        form label {
            display: inline-block;
            margin-bottom: 15px;
            font-weight: bold;
        }

        form label:last-child {
            font-weight: normal;
        }

        form textarea {
            margin-bottom: 15px;
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }

        .review-title {
            font-size: 1.5em;
            font-weight: 600;
        }

        .review-textarea {
            width: 100%;
            min-height: 200px;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            resize: vertical;
        }

        .rating-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .rating-input {
            padding: 8px 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            width: 80px;
            text-align: center;
            font-size: 16px;
        }

        .submit-btn {
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .submit-btn:hover {
            background-color: var(--buttonHoverColor);
        }

        .submit-container {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #f1f1f1;
        }

        .left-labels {
            display: flex;
            gap: 15px;
        }

        /* searchbar */
        .search-bar {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: white;
            padding: 6px 12px;
            border-radius: 25px;
            border: 1px solid #ccc;
            width: 300px;
            margin-top: auto;
            margin-bottom: auto;
        }

        .search-bar input {
            border: 1px;
            outline: none;
            font-size: 14px;
            width: 100%;
            border-radius: 50px;
        }

        header #firstHeader {
            box-shadow: var(--headerBoxShadow) !important;
        }
    </style>
</head>

<body>

    <header>
        <div id="firstHeader">
            <a href="main.php" id="logo"><img src="image/logoTitle.png" alt="logo" id="logoImage"></a>

            <nav>
                <div>
                    <span class="colorButton"><label for="color">Color<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility colorAccessibility">
                        <div class="default option" data-color="defaultColor">Default</div>
                        <div class="option" data-color="lightColor">Light</div>
                        <div class="option" data-color="darkColor">Dark</div>
                    </div>
                </div>

                <div>
                    <span class="fontSizeButton"><label for="fontSize">Font Size<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility fontSizeAccessibility">
                        <div class="option" data-setFontSize="smallFontSize">Small</div>
                        <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                        <div class="option" data-setFontSize="largeFontSize">Large</div>
                        <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
                    </div>
                </div>
                <div>
                    <span class="supportButton"><label for="support">Support<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility support">
                        <span style="color: black;">Follow Us At Instagram!</span>
                        <div>
                            <img src="image/socialMedia/ig_clicked.png" alt="IG Logo">
                            <label for="bookSpare">@BookSpare</label>
                        </div>
                    </div>
                </div>
            </nav>
            <box-icon name='menu' id="burgerIcon" size="10"></box-icon>
        </div>
        <aside>
            <span id="mainButton"><label for="color">Main</label></span>
            <span id="mainButton"><label for="color" id="genreButton">Genre</label></span>

            <div class="accessibility colorAccessibility">
                <div class="default option" data-color="defaultColor">Default</div>
                <div class="option" data-color="lightColor">Light</div>
                <div class="option" data-color="darkColor">Dark</div>
            </div>
            <span class="colorButton"><label for="color">Color</label></span>

            <div class="accessibility fontSizeAccessibility">
                <div class="option" data-setFontSize="smallFontSize">Small</div>
                <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                <div class="option" data-setFontSize="largeFontSize">Large</div>
                <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
            </div>
            <span class="fontSizeButton"><label for="fontSize">Font Size</label></span>

            <div class="accessibility support">
                <span style="color: black;">Follow Us At Instagram!</span>
                <div>
                    <img src="image/socialMedia/ig_clicked.png" alt="IG Logo">
                    <label for="bookSpare">@BookSpare</label>
                </div>
            </div>
            <span class="supportButton"><label for="support">Support</label></span>
        </aside>
    </header>

    <main>

    <?php 

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $comment = $_POST['comment'];
        $rating = $_POST['rating'];

        date_default_timezone_set("Asia/Kuala_Lumpur");
        $todayDate = date("l, F j, Y");
        $todayTime = date("H:i:s");

        $sqlInputBorrower = "INSERT INTO book_borrowed (readerID, postCode, ratingFeedback) VALUES ('$readerID','$postCode','$rating')";
        $resultInputBorrower = $conn->query($sqlInputBorrower);

        $sqlGetBorrowerDetails = "SELECT * FROM book_borrowed WHERE readerID = '$readerID' AND postCode = '$postCode' ORDER BY bookBorrowCode DESC LIMIT 1";
        $resultGetBorrowerDetails = $conn->query($sqlGetBorrowerDetails);
        $borrower = $resultGetBorrowerDetails->fetch_assoc();

        $sqlInputComment = "INSERT INTO comment_rating (postCode, readerID, comment, dateComment, timeComment, bookBorrowCode) VALUES ('$postCode', '$readerID', '$comment', '$todayDate', '$todayTime', '{$borrower['bookBorrowCode']}')";
        $resultInputComment = $conn->query($sqlInputComment);

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

        if ($resultInputBorrower && $resultInputComment) {
            echo "<label class='output'>Comment Rating Saved Successfully!</label>";
            echo "<meta http-equiv='refresh' content='3; URL=profilemyposts.php'>";
        } else {
            echo "<label class='output'>Failed To Comment/ Rate!</label>";
            echo "<meta http-equiv='refresh' content='3; URL=profilemyposts.php'>";
        }

    } else {
        
        echo '<div class="review-container">';
        echo '    <div class="review-header">';
        echo '        <box-icon name="book" class="downArrow"></box-icon>';
        echo '        <h2 class="review-title" style="font-family: Arial, Helvetica, sans-serif;">Book Review Feedback</h2>';
        echo '    </div>';
        
        echo '    <p>You are giving a Feedback Review for the book "' . $post['bookTitle'] . '".</p>';
        
        echo '    <form id="reviewForm" method="POST" action="' . htmlspecialchars("bookReviewFeedback.php?postCode=" . $post['postCode']) . '">';
        echo '        <div>';
        echo '            <label>Write a review:</label>';
        echo '            <textarea style="font-family: Arial, Helvetica, sans-serif;" class="review-textarea" placeholder="Write your comment here.... (Optional)" name="comment" id="comment" required></textarea>';
        echo '        </div>';
        
        echo '        <div class="rating-container">';
        echo '            <div class="rating-left">';
        echo '                <label>Rate (1-10):</label>';
        echo '                <input type="number" class="rating-input" min="1" max="10" name="rating" id="rating" required>';
        echo '                <label>/10</label>';
        echo '            </div>';
        echo '            <input type="submit" class="submit-btn" value="SUBMIT">';
        echo '        </div>';
        echo '    </form>';
        echo '</div>';        
    }

    ?>

    </main>

    <?php include("footer.html"); ?>

</body>

</html>