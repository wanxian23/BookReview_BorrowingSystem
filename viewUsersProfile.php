<?php 
session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
    exit();
}

require("database/database.php");

// Get the readerID from URL
if (!isset($_GET['readerID'])) {
    header("Location: homepage.php");
    exit();
}

$readerID = $_GET['readerID'];

// Fetch selected user's profile data
$sql = "SELECT * FROM Reader_User WHERE readerID = '$readerID'";
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
                      WHERE post.readerID = '$readerID'
                      ORDER BY post.postCode DESC";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">
<head>
    <?php include("headDetails.html") ?>
    <link rel="stylesheet" href="style.css">
    <title>User Profile</title>
    <style>
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
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
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
            border-radius: 12px;
        }

        .post {
            margin: 0 25px 15px 25px;
            border: 2px solid black;
            border-radius: 15px;
            width: 95%;
            background-color: white;
        }

        .head {
            border-bottom: 2px solid;
            padding: 15px;
            background-color: #e4d7fa;
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
    </style>
</head>

<body>
<?php include("header.php"); ?>

<div class="profile-header">
    <div class="profile-left">
        <?php 
            if (!empty($viewedUser['avatar'])) {
                echo "<img src='".$viewedUser['avatar']."' alt='Profile Image'>";
            } else {
                echo '<div class="profile-picture">'. strtoupper($viewedUser['username'][0]) .'</div>';
            }
        ?>
        <div class="profile-name"><?php echo htmlspecialchars($viewedUser['username']); ?></div>
    </div>
</div>

<main>
    <section class="editProfile">
        <div class="tabs">
            <button class="tab active">Posts</button>
        </div>

        <div class="tab-content">
            <?php foreach ($post as $row): ?>
                <div class="post">
                    <div class="head">
                        <div class="postProfile">
                            <?php 
                                $profileLink = "viewUsersProfile.php?readerID=" . $row['readerID'];

                                if (!empty($row['avatar'])) {
                                    echo '<a href="'.$profileLink.'"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
                                } else {
                                    echo '<a href="'.$profileLink.'">'. strtoupper($row['username'][0]) .'</a>';
                                }
                                echo $row['username'];
                            ?>
                        </div>
                    </div>

                    <div class="body">
                        <div class="left">
                            <div class="review">
                                <h2>Book Title: <?= $row['bookTitle']; ?></h2>
                                <h3>
                                    <label>Review: <?= $row['ownerRating']; ?>/10</label>
                                    <label>Genre: <?= $row['genre']; ?></label>
                                </h3>
                            </div>
                            <div class="description">
                                <p>
                                    <?= substr($row['ownerOpinion'], 0, 310); ?>
                                    <a href="bookDetail.php?postCode=<?= $row['postCode']; ?>">... Read More</a>
                                </p>
                            </div>
                        </div>
                        <div class="right">
                            <?php if (!empty($row['frontCover_img'])): ?>
                                <img src="<?= $row['frontCover_img']; ?>" alt="Book Cover">
                            <?php else: ?>
                                <img src="bookUploads/noImageUploaded.png" alt="No Cover">
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="bottom">
                        <h3>Average Review: 1.9</h3>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<footer>
    <h1>Our Social Media</h1>
    <a href="https://www.instagram.com/bookspare_?igsh=NDJmMjl2aGtxdWQ0" target="_blank"></a>
    <p>&copy; 2025 BookSpare. All rights reserved</p>
</footer>
</body>
</html>
