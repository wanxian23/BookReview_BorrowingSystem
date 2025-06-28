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
            display: flex;
            gap: 50px;
            margin: 0;
        }

        main section {
            display: flex;
            flex-direction: column;
            margin-left: 15%;
            width: 100%;
        }

        main form#asideSection {
            display: flex;
            flex-direction: column;
            gap: 10px;
            height: 100vh;
            width: 250px;
            background-color:rgb(212, 210, 229);
            box-shadow: 1px 1px 10px darkgray;
            position: fixed;
            padding: 30px 0;
        }

        main form#asideSection button {
            text-align: center;
            text-decoration: none;
            padding: 20px 50px;
            transition: 0.2s;
            color: black;
            border: none;
            background-color:rgb(212, 210, 229);
        }

        main form#asideSection button:hover {
            box-shadow: 1px 1px 10px rgb(157, 132, 188);
        }

        main form#asideSection button.active {
            font-weight: bold;
            background-color: rgb(197, 193, 230);
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
        color: var(--containerColor);
        border-radius: 15px;
        width: 100%;
        display: flex;
        justify-content: flex-start;
        gap: 40px;
        flex-wrap: wrap;
        padding: 50px 80px;
    }

    @media (max-width: 768px) {
        .results-grid {
            grid-template-columns: 1fr;
        }
    }

        div.post {
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
            height: 250px;
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

        label#trendingWord {
            display: inline;
        }
</style>

</head>

<body>
    <?php include("header.php"); ?>

    <main>

    <?php

        echo '<form id="asideSection" method="GET">';
        // echo '    <input type="hidden" name="postCode" value="' . $postCode . '">';
        $postActive = (!isset($_GET['section']) || $_GET['section'] === 'allPost') ? 'active' : '';
        $bannedActive = (isset($_GET['section']) && $_GET['section'] === 'banned') ? 'active' : '';

        echo '<button type="submit" name="section" value="allPost" class="' . $postActive . '">All Post</button>';
        echo '<button type="submit" name="section" value="banned" class="' . $bannedActive . '">Banned</button>';

        echo '</form>';     
                
    ?>
        <section>
            <div class="results-container">

            <?php 

            if (isset($_GET['section'])) {
                if ($_GET['section'] === 'allPost') {
                    include('postValidationSection/allPost.php');
                } else {
                    include 'postValidationSection/bannedPost.php';
                }
            } else {
                include('postValidationSection/allPost.php');
            }

            ?>

            </div>

            <?php include("footer.html"); ?>
        </section>
    </main>

    <script>
        $(document).ready(function() {
            
            $(".postCode").click(function () {
                let postCode = this.getAttribute("data-postCode");
                console.log(postCode);
                window.location.href = "bookDetail.php?postCode=" + postCode;
            })

        })
    </script>
</body>

</html>