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


$sqlGetPostHighAvg = "SELECT 
                        post.*, 
                        reader.*, 
                        book.*, 
                        AVG(comment.rating) AS averageRating
                    FROM post_review post
                    INNER JOIN reader_user reader USING (readerID)
                    INNER JOIN book_record book USING (bookID)
                    LEFT JOIN comment_rating comment USING (postCode)
                    WHERE post.statusApprove != 'BANNED' AND
                    post.statusApprove != 'SUSPICIOUS'
                    GROUP BY post.postCode
                    ORDER BY averageRating DESC, post.datePosted DESC";
$resultGetPostighAvg = $conn->query($sqlGetPostHighAvg);
$postHighAvg = $resultGetPostighAvg->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <?php include("headDetails.html"); ?>
    <title>Main</title>

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
            display: flex;
            flex-direction: column;
            gap: 40px;
            margin: 40px 5%;
        }

        main div.postButton {
            display: flex;
            justify-content: right;
            gap: 20px;
        }

        main div.postButton button {
            width: 130px;
            height: 50px;
            border-radius: 10px;
            background-color: var(--buttonColor);
            transition: 0.3s;
            color: var(--buttonFontColor);
            border: 2px solid var(--containerColor);
        }

        main div.postButton button:hover {
            background-color: var(--buttonHoverColor);
            cursor: pointer;
        }

        main div.threadPost {
            display: flex;
            gap: 5%;
        }

        main div.threadPost section:nth-child(1) {
            display: block;
        }

        main div.threadPost section {
            border: 2px solid;
            background-color: var(--containerBgColor);
            border-radius: 10px;
            padding: 20px;
            font-size: 20px;
            color: var(--containerColor);
            box-shadow: var(--containerBoxShadow);
        }

        main section.threadContainer {
            display: inline-block;
            width: 20%;
            /* height: 500px; */
        }

        main section article {
            padding: 20px 10px;
        }

        main section.threadContainer div {
            border-bottom: 1px solid lightgray;
            padding: 10px 0;
        }

        main section.threadContainer article div:last-child {
            border: 0px;
            padding: 10px 0 0 0;
        }

        main section.threadContainer article div label {
            display: inline-block;
            font-weight: bold;
            width: 30px;
        }

        main section.threadContainer article div a {
            text-decoration: none;
            color: var(--linkColor);
        }

        section.postContainer {
            width: 75%;
        }

        section.postContainer form#mainSectionForm {
            display: flex;
            border-bottom: 1px solid;
        }

        section.postContainer form#mainSectionForm button {
            text-align: center;
            width: 150px;
            padding: 15px 20px;
            background-color: transparent;
            border: none;
        }

        section.postContainer form#mainSectionForm button:hover {
            font-weight: bold;
            cursor: pointer;
        }

        section.postContainer form#mainSectionForm button.active {
            font-weight: bold;
        }

        section.postContainer article {
            display: flex;
            flex-wrap: wrap;     
            overflow-y: scroll;
            margin: 30px 0 10px 0;
            display: flex;
            gap: 12px;
            height: 410px;
        }

        section.postContainer article div.post {
            margin: 0 25px 15px 25px;
            border: 2px solid var(--containerColor);
            border-radius: 15px;
            width: 27%;
            background-color: var(--postBgColor);
        }


        section.postContainer article div.post div.head {
            border-bottom: 2px solid;
            padding: 15px;
            background-color: var(--postHeaderBgColor);
            border-radius: 15px 15px 0 0;
        }

        section.postContainer article div.post div.head div.postProfile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        section.postContainer article div.post div.head div.postProfile img {
            display: inline-block;
            border-radius: 40px;
            height: 100%;
            width: 100%;    
        }

        section.postContainer article div.post div.head div.postProfile a {
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

        section.postContainer article div.post div.body {
            display: flex;
            border-bottom: 2px solid;
            height: 230px;
        }

        section.postContainer article div.post div.body div.left {
            border-right: 2px solid;
            width: 70%;
        }

        section.postContainer article div.post div.body div.right {
            padding: 20px 30px;
            width: 100%;
            display: flex;
            justify-content: center;
        }

        section.postContainer article div.post div.body div.right img {
            width: 90%;
            height: 100%;
            box-shadow: var(--bookBoxShadow);
        }

        section.postContainer article div.post div.body div.left div.review {
            padding: 15px;
            border-bottom: 2px solid;
        }

        section.postContainer article div.post div.body div.left div.review h3 {
            display: flex;
            justify-content: space-between;
        }

        section.postContainer article div.post div.body div.left div.description {
            overflow-wrap: anywhere;
            padding: 15px;
        }

        section.postContainer article div.post div.body div.left div.description p a {
            text-decoration: none;
            color: var(--linkColor);
        }

        section.postContainer article div.post div.body div.left div.review section.postContainer article:nth-of-type(2) div.post div.bottom {
            padding: 10px;
        }

        section.postContainer article div.post div.bottom {
            padding: 10px;
            display: flex;
            gap: 10px;
            flex-direction: column;
            align-items: center;
        }

        section.postContainer article div.post div.bottom h3 {
            font-size: 0.85em;
        }

        section.postContainer article div.post div.bottom h4 {
            font-weight: normal;
            font-size: 0.75em;
        }


        section.postContainer article div.post div.bottom div.left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        section.postContainer article div.post div.bottom input {
            width: 70%;
            font-size: 0.7em;
            border-radius: 5px;
            padding: 5px;
            border: 1px solid var(--postHeaderBgColor);
            transition: 0.3s;
        }

        section.postContainer article div.post div.bottom input:active {
            border: 1px solid black;
        }

        label#trendingWord {
            display: inline;
        }

        @media (max-width: 915px) {
            main {
                margin: 40px 7%;
            }

            main div.postButton {
                display: flex;
                justify-content: space-between;
            }

            section.postContainer {
                width: 100%;
            }

            main div.threadPost section:nth-child(1) {
                display: none;
            }

            label#trendingWord {
                display: none;
            }

            section.postContainer article:nth-of-type(2) {
                overflow-x: hidden;
            }

            section.postContainer article:nth-of-type(2) div.post div.body {
                height: 550px;
                flex-direction: column;
            }

            section.postContainer article:nth-of-type(2) div.post div.body div.left div.review h3 {
                flex-direction: column;
            }

            section.postContainer article:nth-of-type(2) div.post div.body div.left {
                width: 100%;
                order: 2;
                border-top: 2px solid;
                border-right: 0;
            }

            section.postContainer article:nth-of-type(2) div.post div.body div.right {
                order: 1;
                width: 100%;
                align-items: center;
            }

            section.postContainer article:nth-of-type(2) div.post div.body div.right img {
                width: 50%;
                height: 85%;
            }

            section.postContainer article:nth-of-type(2) div.post div.bottom {
                padding: 10px;
                display: flex;
                gap: 10px;
                flex-direction: column;
            }

            section.postContainer article:nth-of-type(2) div.post {
                width: 100%;
                margin: 0 10px 15px 0;
            }
        }

        @media (min-width: 915px) and (max-width: 1250px) {
            section.postContainer article:nth-of-type(2) div.post {
                width: 500px;
                margin: 0 10px 15px 0;
            }
        }
    </style>

</head>

<body>

    <?php include("header.php"); ?>

    <main>

        <div class="postButton">
            <button id="newPost">New Post</button>
        </div>

        <div class="threadPost">
            <section class="threadContainer">
                <article style="border-bottom: 1px solid var(--containerColor);">
                    <h1 class="center">Trending Book</h1>
                </article>

                <article>
                    <?php 

                        $i = 1;
                        foreach ($postHighAvg as $data) {

                            // Since Im using MYSQLI_ASSOC just now
                            // So I can access by attribute name
                            $value = $data['bookTitle'];
                            echo "<div>";
                            echo "<label for=''>$i</label><a href='".htmlspecialchars("search.php?bookTitle=$value")."'>$value</a>";
                            echo "</div>";
                            $i++;
                            if ($i === 10) {
                                break;
                            }

                        }

                    ?>
                </article>
            </section>

            <section class="postContainer">
            <?php

                echo '<form id="mainSectionForm" method="GET">';
                // echo '    <input type="hidden" name="postCode" value="' . $postCode . '">';
                $generalActive = (!isset($_GET['section']) || $_GET['section'] === 'general') ? 'active' : '';
                $trendingActive = (isset($_GET['section']) && $_GET['section'] === 'trending') ? 'active' : '';

                echo '<button type="submit" name="section" value="general" class="' . $generalActive . '">General</button>';
                echo '<button type="submit" name="section" value="trending" class="' . $trendingActive . '">Trending</button>';

                echo '</form>';     
        
            ?>

                <article class="post">
                    
                    <?php 
                    
                        if (isset($_GET['section'])) {
                            if ($_GET['section'] === 'general') {
                                include('mainSection/generalPost.php');
                            } else {
                                include 'mainSection/trendingPost.php';
                            }
                        } else {
                            include 'mainSection/generalPost.php'; // default section
                        }

                    ?>

                </article>
            </section>
        </div>
    </main>

   <?php include("footer.html"); ?>

   <script>
        $(document).ready(function() {

            $("#newPost").click(function() {
                window.location = "newPost.php";
            });

            $(".postCode").click(function () {
                let postCode = this.getAttribute("data-postCode");
                console.log(postCode);
                window.location.href = "bookDetail.php?postCode=" + postCode;
            })
        });
    </script>
</body>

</html>