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

    <!-- Free Icon Website -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <!-- put link to jquery library by using google CDN or Microsoft CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- UI jQuery library, which include more animation effect -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script src="script.js"></script>

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
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 15px;
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

        .book-details .book-review {
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

        .book-review {
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
            border-radius: 5px;
            padding: 20px;
            font-size: 1em;
            word-break: break-word;
            width: 100%;
        }

        hr {
            border: none;
            border-top: 1.6px solid #848484;
            margin: 0.5rem 0;
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
                <div class="back-button"><i class='bx bx-reply'></i> Back</div>
                <h1>Detail of the Book</h1>
            </div>

            <hr class="header-line">

            <div class="book-container">
                <div class="top-row">
                    <div class="book-image-wrapper">
                        <div class="book-image">
                            <img src="image/bookCover.jpeg" alt="Book Cover">
                        </div>
                        <div class="arrow-icon">
                            <i class="bx bx-caret-right"></i>
                        </div>
                    </div>


                    <div class="vertical-line"></div>

                    <div class="book-content">
                        <div class="bookTitleReview">
                            <span class="book-title">Book Title</span>
                            <span class="book-rating">x.x/10</span><br>
                            <span class="book-author">Author</span><br>
                            <span class="book-genre">Genre</span>
                        </div>
                        <div class="book-review">
                            In my opinion, I think<br>
                            xxxxxxxxxxxxxxxxxx<br>
                            xxxxxx
                        </div>

                    </div>
                </div>
                <div class="synopsis-box">
                    Long synopsis here
                </div>

            </div>

        </article>
    </main>


    <?php include("footer.php"); ?>

</body>

</html>