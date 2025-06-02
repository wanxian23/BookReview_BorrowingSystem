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

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <link rel="icon" href="image/logo.png">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <title>Login Page</title>

    <style>
        :root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;
            --postHeaderBgColor: rgb(220, 196, 238);
            --postBgColor: white;
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
    </style>

</head>

<body>

    <?php include("header.php"); ?>

    <main>
        <article>
            <div class="header-row">
                <div class="back-button"><i class='bx bx-reply'></i> Back</div>
                <h1>Result post based on search "xxx"</h1>
            </div>

            <hr class="header-line">

            <div class="book-posts-wrapper">
                <div class="book-post">
                    <div class="book-post-header">
                        <div class="icon">H</div>
                        <div class="title">XXX</div>
                    </div>
                    <div class="book-post-content">
                        <div class="book-post-image">
                            <img src="image/bookCover.jpeg" alt="Book Cover">
                        </div>
                        <div class="book-details">
                            <div class="book-title-display">Book Title: XXXX XXX</div>
                            <div class="book-review-score">Review: 7.5 / 10</div>
                            <div class="book-genre">Genre: Horror</div>
                            <div class="description">
                                In my opinion, I think xxxxxxxxxxxxxxxxxx
                                xxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxx
                                xxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxxxx
                            </div>
                            <div class="read-more">Read More</div>
                        </div>
                    </div>
                    <div class="book-post-footer">
                        <div class="comment-box">
                            <i class='bx bx-message-square-dots'></i>
                            <input type="text" placeholder="Comment">
                        </div>
                        <div class="average-review">Average Review : 1.9</div>
                    </div>
                </div>

                <div class="book-post">
                    <div class="book-post-header">
                        <div class="icon">H</div>
                        <div class="title">XXX</div>
                    </div>
                    <div class="book-post-content">
                        <div class="book-post-image">
                            <img src="image/bookCover.jpeg" alt="Book Cover">
                        </div>
                        <div class="book-details">
                            <div class="book-title-display">Book Title: XXXX XXX</div>
                            <div class="book-review-score">Review: 7.5 / 10</div>
                            <div class="book-genre">Genre: Horror</div>
                            <div class="description">
                                In my opinion, I think xxxxxxxxxxxxxxxxxx
                                xxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxx
                                xxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxxxx
                            </div>
                            <div class="read-more">Read More</div>
                        </div>
                    </div>
                    <div class="book-post-footer">
                        <div class="comment-box">
                            <i class='bx bx-message-square-dots'></i>
                            <input type="text" placeholder="Comment">
                        </div>
                        <div class="average-review">Average Review : 1.9</div>
                    </div>
                </div>

                <div class="book-post">
                    <div class="book-post-header">
                        <div class="icon">H</div>
                        <div class="title">XXX</div>
                    </div>
                    <div class="book-post-content">
                        <div class="book-post-image">
                            <img src="image/bookCover.jpeg" alt="Book Cover">
                        </div>
                        <div class="book-details">
                            <div class="book-title-display">Book Title: XXXX XXX</div>
                            <div class="book-review-score">Review: 7.5 / 10</div>
                            <div class="book-genre">Genre: Horror</div>
                            <div class="description">
                                In my opinion, I think xxxxxxxxxxxxxxxxxx
                                xxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxx
                                xxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxxxx
                            </div>
                            <div class="read-more">Read More</div>
                        </div>
                    </div>
                    <div class="book-post-footer">
                        <div class="comment-box">
                            <i class='bx bx-message-square-dots'></i>
                            <input type="text" placeholder="Comment">
                        </div>
                        <div class="average-review">Average Review : 1.9</div>
                    </div>
                </div>

                <div class="book-post">
                    <div class="book-post-header">
                        <div class="icon">H</div>
                        <div class="title">XXX</div>
                    </div>
                    <div class="book-post-content">
                        <div class="book-post-image">
                            <img src="image/bookCover.jpeg" alt="Book Cover">
                        </div>
                        <div class="book-details">
                            <div class="book-title-display">Book Title: XXXX XXX</div>
                            <div class="book-review-score">Review: 7.5 / 10</div>
                            <div class="book-genre">Genre: Horror</div>
                            <div class="description">
                                In my opinion, I think xxxxxxxxxxxxxxxxxx
                                xxxxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxx
                                xxxxxxxxxxxxxxxxxx xxxxxxxxxxxxxxxxxxxx
                            </div>
                            <div class="read-more">Read More</div>
                        </div>
                    </div>
                    <div class="book-post-footer">
                        <div class="comment-box">
                            <i class='bx bx-message-square-dots'></i>
                            <input type="text" placeholder="Comment">
                        </div>
                        <div class="average-review">Average Review : 1.9</div>
                    </div>
                </div>
            </div>
        </article>
    </main>

    <?php include("footer.html"); ?>

</body>

</html>