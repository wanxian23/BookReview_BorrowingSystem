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

// Get the readerID from URL
if (!isset($_GET['readerID'])) {
    header("Location: homepage.php");
    exit();
}

$userReaderID = $_GET['readerID'];

// Fetch selected user's profile data
$sql = "SELECT * FROM Reader_User WHERE readerID = '$userReaderID'";
$runSQL = $conn->query($sql);
$viewedUser = $runSQL->fetch_assoc();

if (!$viewedUser) {
    echo "<p>User not found.</p>";
    exit();
}

// Fetch that user's posts
$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      WHERE post.readerID = '$userReaderID'
                      AND post.statusApprove != 'BANNED'
                      AND post.statusApprove != 'SUSPICIOUS'
                      ORDER BY post.postCode DESC";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);


$postCode = "";
if (isset($_REQUEST['postCode'])) {

    $postCode = $_REQUEST['postCode'];
    $borrowID = $_REQUEST['readerID'];

    $sqlBorrowerDetails = "SELECT
                        borrow.*,
                        reader.*,
                        book.bookTitle
                    FROM Book_Borrowed borrow
                    INNER JOIN Reader_User reader USING (readerID)
                    INNER JOIN Post_Review post USING (postCode)
                    INNER JOIN book_record book USING (bookID)
                    WHERE borrow.postCode = '$postCode'
                    AND borrow.readerID = '$borrowID'";
    $resultBorrowDetails = $conn->query($sqlBorrowerDetails);
    $borrow = $resultBorrowDetails->fetch_assoc();
}

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">
<head>
    <?php include("headDetails.html") ?>
    <link rel="stylesheet" href="style.css">
    <title>User Profile</title>
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

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 235px; 
            margin: 30px auto;
            width: 50%;
        }

        .profile-left {
            display: flex;
            flex-direction: column; 
            align-items: center;
            justify-content: center;
        }

        .borrower-profile-left {
            width:100%;
            display: flex; 
            align-items: center;
            justify-content: space-between;
        }

        .borrower-profile-left div:first-child {
            display: flex; 
            align-items: center;
            gap: 20px;
        }

        .borrower-profile-left div:last-child {
            display: flex; 
            align-items: center;
            gap: 20px;
        }

        .borrower-profile-left div:last-child label {
            color: red;
            width: 400px;
            word-wrap: break-word;
        }

        .borrower-profile-left div:last-child a {
            padding: 5px 0;
            text-align: center;
            width: 100px;
            background-color:rgb(186, 180, 242);
            border-radius: 5px;
            transition: 0.2s;
            text-decoration: none;
            border: 2px solid;
            color: black;
        }

        .borrower-profile-left div:last-child a:hover {
            background-color:rgb(206, 203, 234);
        }

        .profile-left img, .borrower-profile-left img {
            width: 110px;
            height: 110px; 
            border-radius: 50%;
            border: 8px solid black;          
        }

        .profile-picture {
            width: 110px;
            height: 110px;
            background: #e0c5ff;
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

        .editProfile {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            border-radius: 12px;
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            box-shadow: var(--bookBoxShadow);
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
            padding: 30px;
            border-radius: 12px;
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            box-shadow: var(--bookBoxShadow);
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: flex-start;
        }

        .post {
            width: 95%;
            margin: 0 auto 30px auto;
            border: 2px solid var(--borderColor);
            border-radius: 15px;
            background-color: var(--postBgColor);
        }


        .head {
            border-bottom: 2px solid;
            padding: 15px;
            background-color: var(--postHeaderBgColor);
            border-radius: 15px 15px 0 0;
        }

        .postProfile {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .postProfile a {
            display: inline-flex;
            text-decoration: none;
            border-radius: 40px;
            height: 40px;
            width: 40px;
            border: 4px solid black;
            background-color: rgb(202, 28, 57);
            align-items: center;
            justify-content: center;
            color: black;
        }

        .postProfile img {
            border-radius: 40px;
            height: 100%;
            width: 100%;    
        }

        .body {
            display: flex;
            border-bottom: 2px solid;
            height: 200px;
            overflow-x: hidden;
            margin: 0;
            padding: 0;
          }

        .body .left {
            border-right: 2px solid;
            width: 70%;
        }

        .body .right {
            padding: 20px;
            width: 30%;
            display: flex;
            justify-content: center;
        }

        .body .right img {
            width: 80%;
            height: 100%;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }

        .review {
            padding: 15px;
            border-bottom: 2px solid;
        }

        .review h3 {
            display: flex;
            justify-content: space-between;
        }

        .description {
            overflow-wrap: anywhere;
            padding: 15px;
        }

        .description p a {
            text-decoration: none;
            color: rgb(65, 116, 227);
        }

        .bottom {
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        .bottom h3 {
            font-size: 0.8em;
        }

        footer {
            margin-top: 50px; /* Adjust the gap as needed */
            text-align: center;
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
</head>

<body>
<?php include("header.php"); ?>

<div class="profile-header">

<?php
    if (isset($_REQUEST['postCode'])) {

        echo '<div class="borrower-profile-left">';
    
        echo '<div>';
        if (!empty($viewedUser['avatar'])) {
            echo "<img src='" . $viewedUser['avatar'] . "' alt='Profile Image'>";
        } else {
            echo "<div class='profile-picture'>" . strtoupper($viewedUser['username'][0]) . "</div>";
        }
        echo '<div class="profile-name">' . htmlspecialchars($viewedUser['username']) . '</div>';
        echo '</div>';

        if ($borrow['statusBorrow'] === "PENDING") {

            echo '<div>';
            echo '<a href="backendLogic/bookApprovalHandling.php?postCode='.$postCode.'&borrowerReaderID='.$borrow['readerID'].'">Approve</a>';
            echo '<a href="backendLogic/bookRejectionHandling.php?postCode='.$postCode.'&borrowerReaderID='.$borrow['readerID'].'">Reject</a>';
            echo '</div>';
        } else if ($borrow['statusBorrow'] === "APPROVED") {
            echo '<div>';
            echo '<label>You Have Approved <b>\''.$borrow['username'].'\'</b><br>To Borrow Book <b>\''.$borrow['bookTitle'].'\'</b></label>';
            echo '</div>';
        } else {
            echo '<div>';
            echo '<label>You Have Reject <b>\''.$borrow['username'].'\'</b><br>To Borrow Book <b>\''.$borrow['bookTitle'].'\'</b></label>';
            echo '</div>';
        }
 
        echo '</div>';

    } else {
        echo '
        <div class="profile-left">';
    
        if (!empty($viewedUser['avatar'])) {
            echo "<img src='" . $viewedUser['avatar'] . "' alt='Profile Image'>";
        } else {
            echo "<div class='profile-picture'>" . strtoupper($viewedUser['username'][0]) . "</div>";
        }
    
        echo '<div class="profile-name">' . htmlspecialchars($viewedUser['username']) . '</div>';
        echo '</div>';
    }
?>

</div>

<main>
    <section class="editProfile">
        <div class="tabs">
            <button class="tab active">Posts</button>
        </div>

        <div class="tab-content">
            <?php foreach ($post as $row): 
            
            
            $averageRating = 0;
            if (!empty($comment)) {

                    $i = 0;
                    foreach($comment as $commentData) {

                        if ($commentData['bookBorrowCode'] != null) {
                            $averageRating += $commentData['ratingFeedback'];
                            $i++;
                        }

                    }
                    
                    if ($i != 0) {
                        $averageRating = $averageRating / $i;
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
                        // echo '        <div class="left">';
                        // echo '            <div class="review">';
                        // echo '                <h2>Book Title: '.$row['bookTitle'].'</h2>';
                        // echo '                <h3><label for="">Review: '.$row['ownerRating'].'/10</label><label for="">Genre: '.$row['genre'].'</label></h3>';
                        // echo '            </div>';
                        // echo '            <div class="description">';
                        // echo '                <p>';
                        // echo substr($row['ownerOpinion'], 0, 180);
                        // echo '                    <a href="bookDetail.php?postCode='.$row['postCode'].'">... Read More</a>';
                        // echo '                </p>';
                        // echo '            </div>';
                        // echo '        </div>';
                        echo '        <div class="right">';
                        if ($row['frontCover_img'] != null) {
                            echo '            <img src="'.$row['frontCover_img'].'" alt="Book Cover">';
                        }  else {
                            echo '            <img src="bookUploads/noImageUploaded.png" alt="Book Cover">';
                        }
                        echo '        </div>';
                        echo '    </div>';

                        echo '    <div class="bottom">';
                        // echo '        <div class="left">';
                        // echo '        </div>';
                        echo '          <h3>'.$row['bookTitle'].'</h3>';
                        if ($averageRating != 0) {
                            echo '<h4>Average Review: '.number_format($averageRating, 1).'</h4>';
                        } else {
                            echo '<h4>Average Review: No Rating</h4>';
                        }
                        echo '    </div>';
                        echo '</div>';
             endforeach; ?>
        </div>
    </section>
</main>

<footer>
    <h1>Our Social Media</h1>
    <a href="https://www.instagram.com/bookspare_?igsh=NDJmMjl2aGtxdWQ0" target="_blank"></a>
    <p>&copy; 2025 BookSpare. All rights reserved</p>
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
