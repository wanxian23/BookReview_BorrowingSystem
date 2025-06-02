<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";

$runSQL = $conn->query(query: $sql);

$user = $runSQL->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- put link to jquery library by using google CDN or Microsoft CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <link rel="icon" href="image/logo.png">
    <link rel="stylesheet" href="style.css">
    <title>Profile Page</title>

    <style>
        main {
            padding: 50px;
            display: flex;
            flex-direction: column;
            gap: 50px;
        }

        .profileContainer {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            display: flex;
            align-items: center;
            justify-content: space-around;
            width: 800px;
            margin: 0 auto;
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

        .profile-picNname {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .edit-profile {
            padding: 8px 16px;
            border-radius: 10px;
            background: white;
            border: 2px solid black;
            cursor: pointer;
            transition: 0.2s;
        }

        .edit-profile:hover {
            background-color: #e4e4e4;
        }


        .tabs {
            display: flex;
            border-bottom: 2px solid black;
            margin-bottom: 0px;
        }

        .tab {
            padding: 10px 20px;
            cursor: pointer;
            border: none;
            background: transparent;
            font-weight: bold;
        }

        .tab.active {
            border-bottom: 4px solid black;
        }

        .tab-content {
            height: 400px;
            overflow-y: auto;
            padding: 20px;
            border: 2px solid #ccc;
            border-top: none;
            border-radius: 0 0 12px 12px;
        }

        .tab-content .review-card {
            border: 1px solid #ccc;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
            background: white;
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 10px;
        }

        .user-initial {
            width: 30px;
            height: 30px;
            background: #aaa;
            border-radius: 50%;
            color: white;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .review-header img {
            width: 80px;
            height: 120px;
            object-fit: cover;
            margin-left: auto;
        }

        .review-body {
            margin-bottom: 10px;
        }

        .review-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .review-footer input {
            width: 70%;
            padding: 5px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .review-container {
            height: 70vh;
            overflow-y: auto;
            padding: 20px 40px 20px 20px;
            margin-top: 10px;
            /* scrollbar-color: #999 transparent; */
        }

        /* 
.review-container::-webkit-scrollbar {
    width: 16px;
}

.review-container::-webkit-scrollbar-thumb {
    background-color: #999;
    border-radius: 4px;
}

.review-container::-webkit-scrollbar-track {
    background: transparent;
}


.tab-content::-webkit-scrollbar-thumb {
    background-color: #999;
    border-radius: 6px;
}

.tab-content::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 6px;
} */
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

    <main>
        <div class="profile-header">
            <div class="profile-picNname">
                <div class="profile-picture"><?php echo $user['username'][0] ?></div>
                <div class="profile-name"><?php echo $user['username'] ?></div>
            </div>

            <button class="edit-profile">Edit Profile</button>
        </div>

        <section class="profileContainer">
            <div class="tabs">
                <button class="tab">My Posts</button>
                <button class="tab active">Reviews</button>
            </div>

            <div class="tab-content">
                <div class="review-card">
                    <div class="review-header">
                        <div class="user-initial">H</div>
                        <div>
                            <strong>Book Title: XXXX XXX</strong><br>
                            Review: 9 / 10 &nbsp;&nbsp;&nbsp; Genre: Mystery
                        </div>
                        <img src=".jpg" alt="Book Cover">
                    </div>
                    <div class="review-body">
                        In my opinion, I think
                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx...
                        <a href="#">Read More</a>
                    </div>
                    <div class="review-footer">
                        <input type="text" placeholder="Comment">
                        <span>Average Review : 2.4</span>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-header">
                        <div class="user-initial">J</div>
                        <div>
                            <strong>Book Title: wswswswswsws</strong><br>
                            Review: 8 / 10 &nbsp;&nbsp;&nbsp; Genre: Fiction
                        </div>
                        <img src="image.jpg" alt="Book Cover">
                    </div>
                    <div class="review-body">
                        In my opinion, I think
                        xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx...
                        <a href="#">Read More</a>
                    </div>
                    <div class="review-footer">
                        <input type="text" placeholder="Comment">
                        <span>Average Review : 2.4</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

   <?php include("footer.html"); ?>

</body>

</html>