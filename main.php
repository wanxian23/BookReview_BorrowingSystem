<?php 

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$username' OR phone = '$username'";
$runSQL = $conn->query(query: $sql);

$user = $runSQL->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Main</title>

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
            color: var(--anchorColor);
        }

        section.postContainer {
            width: 75%;
        }

        section.postContainer article:first-child {
            display: flex;
            gap: 30px;
        }

        section.postContainer article:first-child div {
            text-align: center;
            width: 200px;
        }

        section.postContainer article:first-child div:hover {
            font-weight: bold;
            cursor: pointer;
        }

        section.postContainer article:nth-of-type(2) {
            display: flex;
            overflow-y: scroll;
            margin: 30px 0 10px 0;
            display: flex;
            align-items: center;
            flex-direction: column;
            gap: 20px;
            height: 350px;
        }

        section.postContainer article:nth-of-type(2) div.post {
            margin: 0 25px 15px 25px;
            border: 2px solid var(--containerColor);
            border-radius: 15px;
            width: 70%;
            background-color: var(--postBgColor);
        }


        section.postContainer article:nth-of-type(2) div.post div.head {
            border-bottom: 2px solid;
            padding: 15px;
            background-color: var(--postHeaderBgColor);
            border-radius: 15px 15px 0 0;
        }

        section.postContainer article:nth-of-type(2) div.post div.head div.postProfile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        section.postContainer article:nth-of-type(2) div.post div.head div.postProfile a {
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

        section.postContainer article:nth-of-type(2) div.post div.body {
            display: flex;
            border-bottom: 2px solid;
            height: 200px;
        }

        section.postContainer article:nth-of-type(2) div.post div.body div.left {
            border-right: 2px solid;
            width: 70%;
        }

        section.postContainer article:nth-of-type(2) div.post div.body div.right {
            padding: 20px;
            width: 30%;
            display: flex;
            justify-content: center;
        }

        section.postContainer article:nth-of-type(2) div.post div.body div.right img {
            width: 80%;
            height: 100%;
            box-shadow: var(--bookBoxShadow);
        }

        section.postContainer article:nth-of-type(2) div.post div.body div.left div.review {
            padding: 15px;
            border-bottom: 2px solid;
        }

        section.postContainer article:nth-of-type(2) div.post div.body div.left div.review h3 {
            display: flex;
            justify-content: space-between;
        }

        section.postContainer article:nth-of-type(2) div.post div.body div.left div.description {
            overflow-wrap: anywhere;
            padding: 15px;
        }

        section.postContainer article:nth-of-type(2) div.post div.body div.left div.description p a {
            text-decoration: none;
            color: var(--anchorColor);
        }

        section.postContainer article:nth-of-type(2) div.post div.body div.left div.review section.postContainer article:nth-of-type(2) div.post div.bottom {
            padding: 10px;
        }

        section.postContainer article:nth-of-type(2) div.post div.bottom {
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        section.postContainer article:nth-of-type(2) div.post div.bottom h3 {
            font-size: 0.8em;
        }


        section.postContainer article:nth-of-type(2) div.post div.bottom div.left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        section.postContainer article:nth-of-type(2) div.post div.bottom input {
            width: 70%;
            font-size: 0.7em;
            border-radius: 5px;
            padding: 5px;
            border: 1px solid var(--postHeaderBgColor);
            transition: 0.3s;
        }

        section.postContainer article:nth-of-type(2) div.post div.bottom input:active {
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
            <button id="myPost">My Post</button>
            <button id="newPost">New Post</button>
        </div>

        <div class="threadPost">
            <section class="threadContainer">
                <article style="border-bottom: 1px solid var(--containerColor);">
                    <h1 class="center">Trending Threads</h1>
                </article>

                <article>
                    <div>
                        <label for="">1</label><a href="">#xxxxx</a>
                    </div>

                    <div>
                        <label for="">1</label><a href="">#xxxxx</a>
                    </div>

                    <div>
                        <label for="">1</label><a href="">#xxxxx</a>
                    </div>

                    <div>
                        <label for="">1</label><a href="">#xxxxx</a>
                    </div>

                    <div>
                        <label for="">1</label><a href="">#xxxxx</a>
                    </div>

                    <div>
                        <label for="">1</label><a href="">#xxxxx</a>
                    </div>

                    <div>
                        <label for="">1</label><a href="">#xxxxx</a>
                    </div>

                    <div>
                        <label for="">1</label><a href="">#xxxxx</a>
                    </div>
                </article>
            </section>

            <section class="postContainer">
                <article style="border-bottom: 1px solid var(--containerColor);">
                    <div>
                        General <box-icon name='chevron-down' class="downArrow"></box-icon>
                    </div>

                    <div>
                        Top 10 <label for="" id="trendingWord">Trending</label> <box-icon name='chevron-down'
                            class="downArrow"></box-icon>
                    </div>

                    <div>
                        Newest <box-icon name='chevron-down' class="downArrow"></box-icon>
                    </div>
                </article>

                <article class="post">
                    <div class="post">
                        <div class="head">
                            <div class="postProfile">
                                <a href="">A</a>
                                XXX
                            </div>
                        </div>
                        <div class="body">
                            <div class="left">
                                <div class="review">
                                    <h2>Book Title: XXXXX</h2>
                                    <h3><label for="">Review: 7.5/10</label><label for="">Genre: Horror</label></h3>
                                </div>
                                <div class="description">
                                    <p>
                                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                                        <a href="bookDetail.php">... Read More</a>
                                    </p>
                                </div>
                            </div>
                            <div class="right">
                                <img src="image/bookCover.jpeg" alt="Book Cover">
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="left">
                                <box-icon name='message-minus' id="burgerIcon" size="10"></box-icon>
                                <input type="text" name="comment" id="comment" placeholder="Comment">
                            </div>
                            <h3>Average Review: 1.9</h3>
                        </div>
                    </div>

                    <div class="post">
                        <div class="head">
                            <div class="postProfile">
                                <a href="">A</a>
                                XXX
                            </div>
                        </div>
                        <div class="body">
                            <div class="left">
                                <div class="review">
                                    <h2>Book Title: XXXXX</h2>
                                    <h3><label for="">Review: 7.5/10</label><label for="">Genre: Horror</label></h3>
                                </div>
                                <div class="description">
                                    <p>
                                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                                        <a href="bookDetail.php">... Read More</a>
                                    </p>
                                </div>
                            </div>
                            <div class="right">
                                <img src="image/bookCover.jpeg" alt="Book Cover">
                            </div>
                        </div>
                        <div class="bottom">
                            <div class="left">
                                <box-icon name='message-minus' id="burgerIcon" size="10"></box-icon>
                                <input type="text" name="comment" id="comment" placeholder="Comment">
                            </div>
                            <h3>Average Review: 1.9</h3>
                        </div>
                    </div>
                </article>
            </section>
        </div>
    </main>

   <?php include("footer.html"); ?>
</body>

</html>