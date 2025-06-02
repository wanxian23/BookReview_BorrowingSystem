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

    <link rel="icon" href="image/logo.png">
    <link rel="stylesheet" href="style.css">
    <title>Edit Profile</title>

    <style>
        :root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 20px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --anchorColor: rgb(65, 116, 227);
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 20px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --anchorColor: rgb(65, 116, 227);
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(34, 34, 34);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 15px rgba(227, 227, 227, 0.822);
            --contentBgColor: rgb(53, 53, 53);
            --borderColor: white;

            --anchorColor: rgb(149, 178, 241);
        }

        main {
            padding: 50px;
        }

        article {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin: 0px auto;
            width: 50%;
        }

        .AccountInfo,
        .ProfileDetails,
        .SecurityPass {
            padding: 10px 0 10px;
            margin-bottom: 20px;
            text-align: left;
            color: var(--containerColor);
            border: 2px solid var(--containerColor);
            border-radius: 20px;
            background-color: var(--containerBgColor);
            box-shadow: var(--containerBoxShadow);
        }

        div.head {
            display: flex;
            text-align: left;
            border-bottom: 1px solid var(--containerColor);
            height: 40px;
            padding: 10px 15px 20px;
            gap: 8px;
            align-items: center;
        }

        .edit-link {
            text-decoration: none;
            color: var(--anchorColor);
        }

        main span {
            font-weight: bold;
        }

        .ProfileDetails {
            border-radius: 20px;
            text-align: center;
        }

        .SecurityPass {
            border-radius: 20px;
            text-align: center;
        }

        .AvatarAndDetails {
            display: flex;
            align-items: flex-start;
            gap: 20px;
            padding: 10px 20px;
        }

        .AvatarSection {
            margin-left: 10px;
            display: flex;
            align-items: center;
            flex-direction: column;
            width: 100px;
            gap: 10px;
            justify-content: center;
            margin-top: 35px;
            margin-bottom: 15px;
        }

        .avatar.pic {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 24px;
            font-weight: bold;
            background-color: rgb(179, 160, 216);
            border: 6px solid var(--containerColor);
        }

        .changeAvatar {
            text-decoration: none;
            margin-top: 5px;
            color: var(--anchorColor);
        }

        .Details {
            flex: 1;
            width: 100%;
        }

        .Details p,
        .ProfileDetails p,
        .SecurityPass p {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
            margin: 20px 0;
            text-align: left;
        }

        .info-text {
            text-align: left;
            flex: 1;
        }

        .info-text label {
            font-weight: normal;
        }

        hr {
            background-color: var(--containerBgColor);
        }

        @media (max-width: 600px) {
            article {
                width: 100%;
            }

            .AvatarAndDetails {
                flex-direction: column;
            }

            .AvatarSection {
                margin: 20px auto 10px auto;
            }
        }

        @media (min-width: 600px) and (max-width: 1100px) {
            article {
                width: fit-content;
            }

            .AvatarSection {
                margin: 20px auto 10px auto;
            }
        }
    </style>

</head>

<body>
   
    <?php include("header.php"); ?>

    <main>
        <article>
            <div class="AccountInfo">
                <div class="head">
                    <box-icon name='user' class="downArrow"></box-icon>
                    <h3>Account Info</h3>
                </div>
                <div class="AvatarAndDetails">
                    <div class="AvatarSection">
                        <div class="avatar pic"><?php echo $user['username'][0]; ?></div>
                        <a href class="changeAvatar">Change Avatar</a>
                    </div>
                    <div class="Details">
                        <p> <span class="info-text">Full Name: <label for=""><?php echo $user['username']; ?></label> </span>
                        <a href="profileEdit/editUsername.php" class="edit-link">Edit Name</a></p>
                        <hr>
                        <p> <span class="info-text">Email Address: <label for=""><?php echo $user['email']; ?></label> </span>
                        <a href="profileEdit/editEmail.php"
                                class="edit-link">Edit
                                Email</a></p>
                        <hr>
                        <p> <span class="info-text">Contact Number: <label for=""><?php echo $user['phone']; ?></label> </span>
                        <a href="profileEdit/editContact.php"
                                class="edit-link">Edit
                                No.Phone</a></p>
                    </div>
                </div>
            </div>

            <div class="ProfileDetails">
                <div class="head">
                    <box-icon name='detail' class="downArrow"></box-icon>
                    <h3>Profile Details</h3>
                </div>
                <p><span class="info-text">Date of Birth: <label for=""><?php echo $user['dateOfBirth']; ?></label> </span>
                <a href="profileEdit/editBirth.php"
                        class="edit-link">Edit Date</a></p>
                <hr>
                <p><span class="info-text">Country/Region: <label for=""><?php echo $user['country']; ?></label> </span>
                <a href="profileEdit/editCountry.php"
                        class="edit-link">Edit Country</a>
                </p>
            </div>

            <div class="SecurityPass">
                <div class="head">
                    <box-icon name='lock' class="downArrow"></box-icon>
                    <h3>Security</h3>
                </div>
                <p><span class="info-text">Passwords: <label for="">********</label> </span>
                <a href="profileEdit/editPass.php"
                        class="edit-link">Edit Password</a></p>
            </div>

        </article>

    </main>

    <?php include("footer.html"); ?>

</body>

</html>