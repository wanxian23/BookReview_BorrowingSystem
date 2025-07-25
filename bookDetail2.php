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


$postCode = $_REQUEST['postCode'];
$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*,
                          borrow.statusBorrow
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      LEFT JOIN book_borrowed borrow USING (postCode)
                      WHERE post.postCode = '$postCode'";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_assoc();


$sqlBorrowerDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*,
                          borrow.statusBorrow, borrow.fullname
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      INNER JOIN book_borrowed borrow USING (postCode)
                      WHERE borrow.postCode = '$postCode'
                      AND borrow.readerID = '$readerID'";
$resultGetBorrowerDetails = $conn->query($sqlBorrowerDetails);
$borrower = $resultGetBorrowerDetails->fetch_assoc();


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
                    reader.*,
                    reader.readerID AS commentReaderID
                  FROM Comment_Rating comment
                  INNER JOIN Post_Review post ON comment.postCode = post.postCode
                  INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
                  WHERE comment.postCode = '$postCode'";
$resultGetComemnt = $conn->query($sqlGetComment);
$comment = $resultGetComemnt->fetch_all(MYSQLI_ASSOC);


$sqlAvgComment = "SELECT rating as averageRating
                  FROM Comment_Rating
                  WHERE postCode = '$postCode'";
$resultGetAvgComemnt = $conn->query($sqlAvgComment);
$commentAvg = $resultGetAvgComemnt->fetch_all(MYSQLI_ASSOC);

$averageRating = 0;
if (!empty($commentAvg)) {

    $i = 0;
    foreach($commentAvg as $commentData) {

        $averageRating += $commentData['averageRating'];
        $i++;

    }

    if ($i != 0) {
        $averageRating = $averageRating / $i;
    }

}

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

            --buttonColor: #a9a1ee;
            --buttonFontColor: black;
            --buttonHoverColor: #d8d5ec;

            --commentButtonColor: rgb(161, 178, 238);
            --commentButtonFontColor: black;
            --commentButtonFontColorActive: black;
            --commentButtonHoverColor: rgb(205, 212, 234);

            --linkColor: blue;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;


            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: rgb(134, 155, 195);
            --commentButtonHoverColor: rgb(91, 87, 87);

            --linkColor: blue;
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(34, 34, 34);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
            --contentBgColor: rgb(53, 53, 53);
            --borderColor: white;

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: white;
            --commentButtonHoverColor: rgb(91, 87, 87);

            --linkColor: rgb(119, 167, 190);
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

        main i {
            font-size: 1.5em;
            color: var(--containerColor);
        }

        h1 {
            margin: 0;
            font-size: 1.3em;
            font-weight: bold;
        }

        .book-edit-container {
            display: flex;
            gap: 20px;
            justify-content: space-between;
            align-items: center;
            border-radius: 9px;
            margin: 30px;
            overflow: hidden;
            padding: 10px 20px;
        }

        .book-edit-container div {
            display: flex;
            gap: 10px;
        }

        .book-edit-container div:nth-child(2) {
            gap: 20px;
        }

        .book-edit-container div.status:first-child {
            flex-direction: column;
            width:80%;
            color: red;
        }

        .book-edit-container div:nth-child(2) a {
            text-decoration: none;
            text-align: center;
            width: 120px;
            padding: 10px 20px;
            background-color: var(--buttonColor);
            border-radius: 8px;
            border:none;
            color: var(--buttonFontColor);
            box-shadow: 1px 1px 8px gray;
            transition: 0.2s;
        }

        .book-edit-container div:nth-child(2) a:hover {
            text-decoration: none;
            padding: 10px 20px;
            background-color: var(--buttonHoverColor);
        }

        .book-edit-container div:nth-child(2) a.report {
            background-color: #ff5b5b;
        }

        .book-edit-container div:nth-child(2) a.report:hover {
            background-color:rgb(255, 145, 145);
        }

        .book-container {
            display: flex;
            flex-direction: column;
            border: 1px solid var(--commentButtonFontColorActive);
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
            width: 160px;
            height: 190px;
            flex-shrink: 0;
            box-shadow: var(--containerBoxShadow);
        }

        .book-image-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
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

        .bookTitleReview:first-child {
            text-align: right;
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
            flex-direction: column;
            justify-content: left;
        }

        .book-title {
            font-size: 1.3em;
            font-weight: bold;
        }

        .book-rating {
            float: inline-end;
            font-size: 1.8rem;
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
            height: 120px;
            display: flex;
            gap: 20px;
        }
        
        .button-box a.availableBorrow {
            text-decoration: none;
            background-color: var(--commentButtonColor);
            color: var(--borderColor);
            border: 2px solid var(--borderColor);
            border-radius: 7px;
            width: 100px;
            text-align: center;
            height: 30px;
            transition: 0.2s;
        }
        
        .button-box a.availableBorrow:hover {
            background-color: var(--buttonHoverColor);
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
            color: black;
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
            gap: 30px;    
        }

        .comment-box form div.inputContainer div:first-child {
            width: 65%;
        }

        .comment-box form div.inputContainer box-icon {
            width: 8%;
        }

        .comment-box textarea, .comment-box input[type="number"] {
            min-height: 10px;
            border-radius: 6px;
            padding: 3px 10px;
            resize: vertical;
            overflow: auto; 
        }

        .comment-box textarea {
            width: 80%;  
        }

        .comment-box input[type="number"]{
            width: 30%;
        }

        .comment-box input[type="submit"] {
            padding: 8px 15px;
            border-radius: 6px;
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
            border: 2px solid var(--commentButtonFontColorActive);
            transition: 0.2s;
        }

        .comment-box input[type="submit"]:hover {
            background-color: var(--buttonHoverColor);
        }

        hr {
            border: none;
            border-top: 1.6px solid #848484;
            margin: 0.5rem 0;
        }

        .viewComment-box {
            border-radius: 5px;
            padding: 20px 20px 0 20px;
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
            background-color: var(--commentButtonColor);
            border-radius: 10px;
            border: 2px solid var(--commentButtonFontColor);
            color: var(--commentButtonFontColor);
            border: 2px solid var(--commentButtonFontColorActive);
            transition: 0.2s;
        }

        .viewComment-box .commentOption input:hover,
        .viewComment-box .commentOption button:hover {
            text-decoration: none;
            padding: 10px 20px;
            background-color:var(--commentButtonHoverColor);
            border-radius: 10px;
        }
        
        .viewComment-box .commentOption .active,
        .viewComment-box .commentOption .active {
            font-weight: bold;
            border-bottom: 5px solid var(--commentButtonFontColorActive);
        }

        .viewComment-box .commentContainer,
        .viewComment-box .nestedCommentContainer {
            border-bottom: 1px solid;
            padding: 0 20px 20px 20px;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .viewComment-box .commentContainer:last-child {
            margin-bottom: 20px;
        }

        .viewComment-box .nestedCommentContainer {
            width: 95%;
            border-bottom: 0;
            border-top: 1px solid;
            padding: 20px 30px 0 30px;
            margin: 0 auto;
        }

        .viewComment-box div.postProfile {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .viewComment-box div.postProfile div,
        .viewComment-box div.postProfile form.replyComemntForm {
            display: flex;
            align-items: center;
            gap: 20px;           
        }

        .viewComment-box div.postProfile div:nth-child(2) a {
            text-decoration: none;
            padding: 5px 10px;
            background-color: #a9a1ee;
            color: black;
            border-radius: 5px;
            border: 2px solid;
            transition: 0.2s;
        }

        .viewComment-box div.postProfile div:nth-child(2) a:hover {
            background-color:rgb(209, 206, 239);
        }

        .viewComment-box div.postProfile img {
            display: inline-block;
            border-radius: 40px;
            height: 100%;
            width: 100%;    
        }

        .viewComment-box div.postProfile div:first-child a {
            display: inline-flex;
            text-decoration: none;
            border-radius: 40px;
            height: 40px;
            width: 40px;
            border: 4px solid var(--containerColor);
            background-color:#d8d5ec ;
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

            <?php

                // If the post belongs to reader yg login
                // Display this
                if ($post['readerID'] == $readerID) {

                    echo '<div class="book-edit-container">';
                    echo '<div class="status">';
                    if ($post['statusApprove'] === "BANNED") {
                        echo '<div><h2>Post Status:</h2><label>Banned</label></div>';
                        echo '<div><h2>Reason Banned:</h2><label>'.$post['statusApproveMessage'].'</label></div>';
                    } else if ($post['statusApprove'] === "SUSPICIOUS") {
                        echo '<div><h2>Post Status:</h2><label>Suspicious (Validating By Admin...)</label></div>';                
                    }
                    echo '</div>';
                    echo '<div>';
                    if ($post['statusApprove'] !== "BANNED") {
                    echo '<a href="editPost.php?postCode='.$post['postCode'].'">Edit Post</a>';
                    }
                    echo '<a href="confirmationDeletePost.php?postCode='.$post['postCode'].'">Delete Post</a>';
                    echo '</div>';
                    echo '</div>';

                } else {

                    if (!empty($borrower)) {
                        echo '<div class="book-edit-container">';
                        echo '<div class="status">';
                        if ($borrower['statusBorrow'] ===  "PENDING") {
                            echo '<div><h2>Book Borrow Request Status:</h2><label>Pending</label></div>';
                            echo '</div>';
                            echo '<div>';
                            echo '<a href="cancelBorrowRequest.php?postCode='.$borrower['postCode'].'" style="width: 200px;">Cancel Borrow Request</a>';
                            echo '</div>';
                        } else if ($borrower['statusBorrow'] === "APPROVED") {
                            echo '<div><h2>Book Borrow Request Status:</h2><label>Approved</label></div>';
                        } else {
                            echo '<div><h2>Book Borrow Request Status:</h2><label>Rejected</label></div>';
                            echo '</div>';
                            echo '<div>';
                            echo '<a href="cancelBorrowRequest.php?postCode='.$borrower['postCode'].'" style="width: 200px;">Cancel Borrow Request</a>';
                            echo '</div>';
                        }
                        echo '</div>';                        
                        echo '</div>';                        
                    } else {
                        echo '<div class="book-edit-container">';
                        echo '<div class="status">';
                        echo '</div>';
                        echo '<div>';
                        echo '<a href="reportPost.php?postCode='.$postCode.'" class="report">Report Post</a>';
                        echo '</div>';
                        echo '</div>';                         
                    }

                }

                echo '<div class="book-container">';

                echo '<div class="top-row">';
                echo '    <div class="book-image-wrapper">';
                echo '        <div class="book-image">';
                echo '            <img src="'.$post['frontCover_img'].'" alt="Book Cover">';
                echo '        </div>';
                echo '    </div>';

                echo '    <div class="vertical-line"></div>';

                echo '    <div class="book-content">';
                echo '        <div class="bookTitleReview">';
                echo '<span class="book-date">' . date("F j, Y H:i", strtotime($post['datePosted'])) . '</span>';

                echo '        </div>';
                echo '        <div class="bookTitleReview">';
                echo '            <span class="book-title">Book Title: '.$post['bookTitle'].'</span>';
                if ($averageRating != 0) {
                    echo '            <span class="book-rating">'.number_format($averageRating, 1).'/10</span><br>';

                } else {
                    echo '            <span class="book-rating">No Rating</span><br>';
                }
                echo '            <span class="book-author">Author: '.$post['author'].'</span><br>';
                echo '            <span class="book-genre">Genre: '.$post['genre'].'</span>';
                echo '        </div>';
                echo '        <div class="button-box">';
                if ($post['readerID'] != $readerID) {

                    if (!empty($borrower)) {

                        if ($post['statusPostBorrow'] == "YES") {
                            if ($borrower['statusBorrow'] !== "PENDING") {
                                echo "<label>Please Click On This Button, If You Are Interested To Borrow This Book!</label>";
                                echo "<a href='confirmationBorrow.php?postCode=".$postCode."' class='availableBorrow'>Borrow</a>";
                            }
                        } else {
                            if ($borrower['statusBorrow'] === "PENDING") {
                                echo "          <label style='color: red;'>You Already Sent A Borrow Request To '{$post['username']}'!<label><br>";
                                echo "          <label style='color: red;'>Please Kindly Wait For Book Owner To Respond!<label>";
                            } else if ($borrower['statusBorrow'] === "APPROVED") {
                                echo "          <label style='color: red;'>Your Borrow Request Has Been Approved By '{$post['username']}'!<label><br>";
                                if (empty($borrower['fullname']))
                                    echo "          <label style='color: red;'>Please Fill In The Relevant Form!<label>";
                                else 
                                    echo "          <label style='color: red;'>Your Form Has Submitted! Owner Will Get Back Soon For More Information!<label><br>";
                            } else {
                                echo "          <label style='color: red;'>Your Borrow Request Has Been Rejected By '{$post['username']}'!<label><br>";
                                echo "          <label style='color: red;'>Please Cancel Your Borrow Request If You Wanna Make Request Again!<label>";
                            }
                        }

                    } else {
                        
                        if ($post['statusPostBorrow'] == "YES") {
                            echo "<label>Please Click On This Button, If You Are Interested To Borrow This Book!</label>";
                            echo "<a href='confirmationBorrow.php?postCode=".$postCode."' class='availableBorrow'>Borrow</a>";
                        } else {
                            echo "<label>This Book Is Not Available For Borrow Currently!<label>";
                        }
                    }

                } else {
            
                    if ($post['statusPostBorrow'] === "NO") {
                        if ($post['statusBorrow'] == "PENDING") {
                            echo "<label>You Are The Owner Of This Book!<label><br>";
                            echo "<label style='color: red;'>A Borrow Request Has Made By Someone, Don't Forget To Check!<label>";
                        } else if ($post['statusBorrow'] == "APPROVED") {
                            echo "<label>You Are The Owner Of This Book!<label><br>";
                            echo "<label style='color: red;'>You Have Approved A Borrow Request, So This Post Is Not Available To Borrow Currently!<label>";
                        } else if ($post['statusPostBorrow'] == "YES") {
                            echo "<label>You Are The Owner Of This Book!<label><br>";
                            echo "<label style='color: red;'>This Post Is Available For Borrow!<label>";
                        } else {
                            echo "<label>You Are The Owner Of This Book!<label><br>";
                            echo "<label style='color: red;'>This Post Is NOT Available For Borrow!<label>";
                        }
                    } else {
                        echo "<label>You Are The Owner Of This Book!<label><br>";
                        echo "<label style='color: red;'>This Post Is Available For Borrow!<label>";            
                    }
                }

                echo '        </div>';
                echo '    </div>';
                echo '</div>';

                echo '<div class="synopsis-box">';
                echo '<h2>Synopsis Of The Book</h2>';
                echo nl2br(htmlspecialchars($post['synopsis']));
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
                echo '  <form id="commentForm" method="POST" action="' . htmlspecialchars("backendLogic/commentHandling.php?postCode=" . $postCode) . '">';
                echo '      <div class="inputContainer">';
                echo '          <div>';
                echo '              <box-icon name="message-minus" id="burgerIcon" size="10"></box-icon>';
                echo '              <textarea name="comment" id="comment" placeholder="Comment"></textarea>';
                echo '              <input type="number" name="rating" id="rating"  min="1" max="10"  placeholder="Rate x/10"></input>';
                echo '          </div>';
                echo '          <div>';
                echo '              <input type="submit" name="addComment" value="Add Comment">';
                echo '          </div>';
                echo '      </div>';
                echo '  </form>';
                echo '</div>';

                echo '<div class="viewComment-box">';
                        include 'bookDetailsSection/commentSection.php';
                echo '</div>';
            echo '</div>';

            ?>

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

                if (document.getElementById("rating").value === "") {
                    event.preventDefault();
                    window.alert("Rating Cannot Be Empty Before Submit!");
                    return;
                }
            });

            // $("#shareLink").click(function(event) {
            //     event.preventDefault(); // Prevent the anchor from navigating
            //     const linkToCopy = this.getAttribute("sharelink");

            //     navigator.clipboard.writeText(linkToCopy)
            //         .then(() => {
            //             alert("Link copied to clipboard!");
            //         })
            //         .catch(err => {
            //             alert("Failed to copy: " + err);
            //         });
            // });

        });
    </script>

</body>

</html>