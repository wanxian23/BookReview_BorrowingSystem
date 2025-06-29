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

$bookSelected = $_GET['book'];

$sqlGetPostDetails = "SELECT 
                        post.*,
                        reader.*,
                        book.*
                    FROM post_review post
                    INNER JOIN reader_user reader USING (readerID)
                    INNER JOIN book_record book USING (bookID)
                    WHERE book.bookTitle LIKE '%$bookSelected%'";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <?php include("headDetails.html"); ?>

    <title>Genre Details</title>

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

            --postHeaderBgColor: rgb(220, 196, 238);
            --postBgColor: white;

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

            --postHeaderBgColor: white;
            --postBgColor: white;

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

            
            --postHeaderBgColor: rgb(1, 1, 1);
            --postBgColor: rgb(45, 45, 45);

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
            max-width: 1250px;
            padding: 20px 50px;
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
            /* Adjusted gap to be smaller */
            gap: 20px; /* Reduced gap */
            padding: 5px 0;
            margin-bottom: 20px;
            justify-content: space-between !important;
            width: 55%;
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
            /* Removed display: none; to make it visible */
            display: flex; 
        }

        i {
            font-size: 1.5em;
            color: var(--containerColor);
        }

        .header-row h1 {
            margin: 0;
            font-size: 1.3em;
            font-weight: bold;
            /* Adjusted width to allow for back button and still center title */
        }

        .book-posts-wrapper {
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
            gap: 40px;
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
            /* Slightly adjusted min-height for better fit */
            min-height: 300px; 
        }

        .book-post-header {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            border-bottom: 1px solid var(--borderColor);
            background-color: var(--postHeaderBgColor); 
        }

        .book-post-header .icon {
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

        .book-details .book-review-score {
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        /* Removed .book-details .book-genre as it's not in the image */

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
            width: 100px;
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
            margin: 0 0 25px 0;
            border: 2px solid var(--containerColor);
            border-radius: 15px;
            width: 22%;
            height: 380px;
            background-color: var(--postBgColor);
        }


        div.post div.head {
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
            background-color: #d8d5ec;
            align-items: center;
            justify-content: center;
            color: black;
        }

        div.post div.body {
            display: flex;
            border-bottom: 2px solid;
            height: 230px;
        }

        div.post div.body div.left {
            border-right: 2px solid;
            width: 70%;
        }

        div.post div.body div.right {
            padding: 20px 30px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        div.post div.body div.right img {
            width: 90%;
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
            color: var(--linkColor);
        }

        div.post div.body div.left div.review section.postContainer article:nth-of-type(2) div.post div.bottom {
            padding: 10px;
        }

        div.post div.bottom {
            padding: 10px;
            display: flex;
            gap: 10px;
            flex-direction: column;
            align-items: center;
        }

        div.post div.bottom h3 {
            font-size: 0.85em;
        }

        div.post div.bottom h4 {
            font-weight: normal;
            font-size: 0.75em;
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
            <div class="header-row">
                <div onclick="" class="back-button"><i class='bx bx-reply'></i> Back</div>
                <h1><?php echo $bookSelected ?></h1> 
            </div>

            <hr class="header-line">

            <div class="book-posts-wrapper">

                <?php

                    foreach($post as $row) {

                        $sqlAvgComment = "SELECT rating as averageRating
                        FROM Comment_Rating
                        WHERE postCode = '{$row['postCode']}'";
                    $resultGetAvgComemnt = $conn->query($sqlAvgComment);
                    $commentAvg = $resultGetAvgComemnt->fetch_all(MYSQLI_ASSOC);
                
                    $averageRating = 0;
                    if (!empty($commentAvg)) {
                
                        $x = 0;
                        foreach($commentAvg as $commentData) {
                
                            $averageRating += $commentData['averageRating'];
                            $x++;
                
                        }
                
                        if ($x != 0) {
                            $averageRating = $averageRating / $x;
                        }
                
                    }

                                        echo '<div class="post postCode" data-postCode="'.$row['postCode'].'">';
                                        echo '    <div class="head">';
                                        echo '        <div class="postProfile">';
                                        
                                        $profileLink = "viewUsersProfile.php?readerID=" . $row['readerID'];
                        
                                        if ($row['readerID'] != $readerID) {
                                            if (!empty($row['avatar'])) {
                                                echo '<a href="'.$profileLink.'"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
                                            } else {
                                                echo '<a href="'.$profileLink.'">'.$row['username'][0].'</a>';
                                            }
                                        } else {
                                            if (!empty($row['avatar'])) {
                                                echo '<a href="profilemyposts.php"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
                                            } else {
                                                echo '<a href="profilemyposts.php">'.$row['username'][0].'</a>';
                                            }                                
                                        }
                        
                                        echo $row['username'];
                                        echo '        </div>';
                                        echo '    </div>';
                        
                                        echo '    <div class="body">';
                                        echo '        <div class="right">';
                                        if ($row['frontCover_img'] != null) {
                                            echo '            <img src="'.$row['frontCover_img'].'" alt="Book Cover">';
                                        }  else {
                                            echo '            <img src="bookUploads/noImageUploaded.png" alt="Book Cover">';
                                        }
                                        echo '        </div>';
                                        echo '    </div>';
                        
                                        echo '    <div class="bottom">';
                                        echo '          <h3>'.$row['bookTitle'].'</h3>';
                                        if ($averageRating != 0) {
                                            echo '<h4>Average Review: '.number_format($averageRating, 1).'</h4>';
                                        } else {
                                            echo '<h4>Average Review: No Rating</h4>';
                                        }
                                        echo '    </div>';
                                        echo '</div>';
            
                    }

                ?>

             </div>
        </article>
    </main>

    <?php include("footer.html"); ?>

    
    <script>
        $(document).ready(function() {

            $(".postCode").click(function () {
                let postCode = this.getAttribute("data-postCode");
                console.log(postCode);
                window.location.href = "bookDetail.php?postCode=" + postCode;
            })

        });
    </script>

</body>

</html>