<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("../database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];
$readerID = $_SESSION['readerID'];

$sql = "SELECT * FROM admin WHERE adminUsername = '$username'
OR adminEmail = '$email' OR adminPhone = '$contact'";
$runSQL = $conn->query($sql);
$admin = $runSQL->fetch_assoc();

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
            gap: 50px;
            margin: 0;
        }

        main section {
            display: flex;
            flex-direction: column;
            margin-left: 15%;
            width: 100%;
        }
        
        main form#section {
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

        main form#section button {
            text-align: center;
            text-decoration: none;
            padding: 20px 50px;
            transition: 0.2s;
            color: black;
            border: none;
            background-color:rgb(212, 210, 229);
        }

        main form#section button:hover {
            box-shadow: 1px 1px 10px rgb(157, 132, 188);
        }

        main form#section button.active {
            font-weight: bold;
            background-color: rgb(197, 193, 230);
        }

        main section article {
            padding: 60px 80px;
            display: flex;
            gap: 40px;
            justify-content: flex-start;
            flex-wrap: wrap;
        }

        div.post {
            margin: 0 0 25px 0;
            border: 2px solid var(--containerColor);
            border-radius: 15px;
            width: 22%;
            height: 450px;
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
            flex-direction: column;
        }

        div.post div.body div.left {
            border-right: 2px solid;
            width: 70%;
        }

        div.post div.body div.right {
            padding: 20px 30px;
            width: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-bottom: 2px solid;
        }

        div.post div.body div.right img {
            width: 90%;
            height: 200px;
            box-shadow: var(--bookBoxShadow);
        }
        
        div.post div.right h3 {
            font-size: 0.85em;
        }

        div.post div.right h4 {
            font-weight: normal;
            font-size: 0.75em;
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

        div.post .bottom {
            padding: 15px;
            display: flex;
            gap: 10px;
            flex-direction: column;
            align-items: center;
        }

        div.post .statusButton {
            flex-direction: row;
            justify-content: space-around;
        }

        div.post .bottom h3 {
            font-size: 0.85em;
        }

        div.post .bottom h4 {
            font-weight: normal;
            font-size: 0.75em;
        }

        div.post .bottom a {
            padding: 5px 0;
            text-align: center;
            width: 80px;
            background-color:rgb(186, 180, 242);
            border-radius: 5px;
            transition: 0.2s;
            text-decoration: none;
            border: 2px solid;
            color: black;
        }

        div.post .bottom a:hover {
            background-color:rgb(206, 203, 234);
        }

        div.post div.right div.left {
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

    <?php include("adminHeader.php"); ?>

    <main>

    <?php

        echo '<form id="section" method="GET" action="adminMain.php">';
        // echo '    <input type="hidden" name="postCode" value="' . $postCode . '">';
        $pendingActive = (!isset($_GET['section']) || $_GET['section'] === 'pending') ? 'active' : '';
        $approvedActive = (isset($_GET['section']) && $_GET['section'] === 'approved') ? 'active' : '';
        $rejectedActive = (isset($_GET['section']) && $_GET['section'] === 'rejected') ? 'active' : '';

        echo '<button type="submit" name="section" value="pending" class="' . $pendingActive . '">Pending</button>';
        echo '<button type="submit" name="section" value="approved" class="' . $approvedActive . '">Approved</button>';
        echo '<button type="submit" name="section" value="rejected" class="' . $rejectedActive . '">Rejected</button>';

        echo '</form>';     
                      
    ?>

        <section>
            <article>

            <?php 

                if (isset($_GET['section'])) {
                    if ($_GET['section'] === 'pending') {
                        include('postValidationSection/pendingPost.php');
                    } elseif ($_GET['section'] === 'approved') {
                        include 'postValidationSection/approvalPost.php';
                    } else {
                        include 'postValidationSection/rejectedPost.php';
                    }
                } else {
                    include 'postValidationSection/pendingPost.php'; // default section
                }

            ?>

            </article>

            <?php include("../footer.html"); ?>
        </section>
 
    </main>

   <script>
        $(document).ready(function() {
            $("#myPost").click(function() {
                window.location = "mainmyposts.php";
            });

            $("#newPost").click(function() {
                window.location = "newPost.php";
            });

            $(".postCode").click(function () {
                let postCode = this.getAttribute("data-postCode");
                console.log(postCode);
                window.location.href = "adminBookDetail.php?postCode=" + postCode;
            })
        });
    </script>
</body>

</html>