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

$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      WHERE post.readerID = '$readerID'
                      AND post.statusApprove != 'BANNED'
                      AND post.statusApprove != 'SUSPICIOUS'
                      ORDER BY post.postCode DESC";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

    <?php include("headDetails.html") ?>
    <link rel="stylesheet" href="style.css">
    <title>Login Page</title>

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
            margin: 2% 0;
        }
        
        .editProfile {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            box-shadow: var(--bookBoxShadow);
            border-radius: 12px;
        }

        .profile-header {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 235px; 
    margin-top: 30px;
    margin-bottom: 30px;
}

        .profile-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .profile-left img {
            display: flex;
            width: 110px;
            height: 110px; 
            border-radius: 50%;
            border: 8px solid black;          
        }

        .profile-picture {
            width: 110px;
            height: 110px;
            background-color: #d8d5ec;
            border-radius: 50%;
            font-size: 24px;
            font-weight: bold;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 8px solid black;
        }

        .profile-name {
            font-size: 35px;
            font-weight: bold;
        }

        .edit-profile {
            padding: 8px 16px;
            border-radius: 10px;
            background: white;
            border: 2px solid black;
            cursor: pointer;
            font-weight: bold;
        }

        .tabs {
            display: flex;
            border-bottom: 2px solid black;
            margin-bottom: 25px;
        }

        .tab {
            padding: 20px 30px;
            cursor: pointer;
            border: none;
            background: transparent;
            font-weight: bold;
            color: var(--containerColor);
        }

         .tab.active {
            text-decoration: underline;
            text-decoration-thickness: 4px;
            text-underline-offset: 8px;
        }

        .tab-content {
            height: 400px;
            overflow-y: auto;
            padding: 20px;
            border-radius: 12px 12px 12px 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: flex-start;
        }

        .review-card {
            border-radius: 15px;
            margin-bottom: 20px;
            color: var(--containerColor);
            box-shadow: var(--bookBoxShadow);
            overflow: hidden;
        }

        .review-header {
            background-color: var(--containerColor);
            padding: 50px 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .user-initial {
            width: 35px;
            height: 35px;
            background: #333;
            border-radius: 50%;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .user-name {
            font-weight: bold;
            font-size: 16px;
        }

        .review-content {
            display: flex;
            padding: 15px;
            gap: 15px;
        }

        .review-left {
            flex: 1;
        }

        .book-title {
            font-weight: bold;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .review-details {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .review-text {
            font-size: 14px;
            line-height: 1.4;
            margin-bottom: 15px;
        }

        .read-more {
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }

         .book-image {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 12px;
            text-align: center;
        }

        .comment-section {
            background: #f8f8f8;
            padding: 10px 15px;
            border-top: 1px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .comment-input {
            width: 60%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .average-review {
            font-size: 14px;
            font-weight: bold;
        }

        div.post {
            margin: 0 0 25px 0;
            border: 2px solid var(--containerColor);
            border-radius: 15px;
            width: 30%;
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

        label#trendingWord {
            display: inline;
        }
    </style>

    <script>
        $(document).ready(function () {
            $(".edit-profile").click(function () {
                window.location = "profile.php";
            });
        });
    </script>


</head>

<body>
  <?php include("header.php"); ?>

    <div class="profile-header">
    <div class="profile-left">
        <?php 
            if ($user['avatar'] != null) {
                echo "<img src='".$user['avatar']."' alt='Profile Image'>";
            } else {
                echo '<div class="profile-picture">'.$user['username'][0].'</div>';
            }
        ?>
        <div class="profile-name"><?php echo $user['username']; ?></div>
    </div>
    <button class="edit-profile">Edit Profile</button>
</div>
     <main>
        <section class="editProfile">
            </div>

            <form class="tabs" method="GET">
            <?php

                $mypostActive = (!isset($_GET['mypostSection']) || $_GET['mypostSection'] === 'myPost') ? 'active' : '';
                $reviewActive = (isset($_GET['mypostSection']) && $_GET['mypostSection'] === 'review') ? 'active' : '';

            ?>
                <button type="submit" class="tab <?php echo $mypostActive; ?>" name="mypostSection" value="myPost">My Posts</button>
                <button type="submit" class="tab <?php echo $reviewActive; ?>" name="mypostSection" value="review">Reviews</button>
            </form>

            <div class="tab-content">
            
                <?php
                    if (isset($_GET['mypostSection'])) {
                        
                        if ($_GET['mypostSection'] === "myPost") {
                            include("profileMyPostSection/myPostSection.php");
                        } else {
                            include("profileMyPostSection/reviewSection.php");
                        }

                    } else {
                        include("profileMyPostSection/myPostSection.php");
                    }
                ?>
                
            </div>
        </section>
    </main>
    <footer>
        <h1>Our Social Media</h1>
        <a href="https://www.instagram.com/bookspare_?igsh=NDJmMjl2aGtxdWQ0" target="_blank"></a>
        <p>Copyright &copy; 2025 BookSpare. All right reserved</p>
    </footer>

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