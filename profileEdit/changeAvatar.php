<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: ../login.php");
}

require("../database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];
$readerID = $_SESSION['readerID'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();

// Check if the form has submit (POST)
$showPHPHandle = ($_SERVER['REQUEST_METHOD'] === "POST");

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

    <?php include("headDetails.html"); ?>

    <title>Change Avatar</title>

    <style>
        :root {
            --containerBgColor: white;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: rgb(244, 244, 244);
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(40, 39, 39);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;

            --anchorColor: rgb(149, 178, 241);
        }

        main {
            margin: 5% 6%;
        }

        .edit-container {
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            box-shadow: var(--containerBoxShadow);
            border-radius: 12px;
            padding: 30px;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
        }

        .edit-header {
            text-align: center;
            align-items: center;
            font-size: 1.4em;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--containerColor);
        }

        div.oldAvatarContainer {
            display: flex;
            align-items: center;
            gap: 20px;
            flex-direction: column;
            width: 50%;
            border-bottom: 1px solid;
            padding: 30px;
        }

        div.oldAvatarContainer img {
            border: 8px solid;
            border-radius: 100px;
            width: 150px;
            height: 150px;
        }

        div.oldAvatarContainer .profile-picture {
            border: 10px solid black;
            border-radius: 100px;
            width: 150px;
            height: 150px;
            display: flex;      
            align-items: center; 
            justify-content: center;   
            background-color: purple;
            font-size: 3em;
            font-weight: bold;
            color: white;
        }

        .confirm-btn {
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            margin-top: 10px;
            height: 40px;
            width: 120px;
        }

        .confirm-btn:hover {
            background-color: var(--buttonHoverColor);
        }

        .formEdit {
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        .formEdit p {
            display: flex;
            gap: 20px;
            width: 60%;
            font-size: 1.3em;
            text-align: left;
            font-weight: bold;
        }

        .formEdit label {
            font-weight: bold;
            font-size: 1.2em;
        }

        .formEdit input {
            padding: 0 5px;
        }

        .phpHandle {
            display: none;
            justify-content: center;
            align-items: center;
            padding: 160px;
            font-size: 1.5em;           
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#confirmBtn").click(function(event) {
                let fileInput = document.getElementById("avatar");
                let file = fileInput.files[0];

                if (!file) {
                    window.alert("Please select an image to upload");
                    event.preventDefault();
                    return;
                }
                
               const allowedTypes = ["image/jpeg", "image/jpg", "image/png"];
               const maxSize = 2 * 1024 * 1024; // 2MB

               if(!allowedTypes.includes(file.type)){
                window.alert("Only JPG, PNG, JPEG images are allowed.");
                event.preventDefault();
                return;
               }

               if(file.size > maxSize){
                window.alert("File size must be 2MB or less.");
                event.preventDefault();
                return;
               }
            });
        });
    </script>
</head>

<body>
    <?php include("header.php"); ?>

    <!-- Show the prompt out info if the form has submit -->
    <div class="phpHandle" style="<?php echo $showPHPHandle ? 'display: flex;' : 'display: none;'; ?>">
    <?php 

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_FILES['avatar'])) {
        $targetDir = "avatarUploads/";
        if(!file_exists("../".$targetDir)){
            mkdir("../".$targetDir, 0755, true);
        }

        $file = $_FILES['avatar'];
        $fileName = uniqid("img_")."_".basename($file["name"]);
        $targetFile = $targetDir.$fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedTypes = ['jpg', 'jpeg', 'png'];

         if (in_array($imageFileType, $allowedTypes) && $file["size"] <= 2 * 1024 * 1024) {
                if (move_uploaded_file($file["tmp_name"], "../".$targetFile)) {
                    $updateSQL = "UPDATE Reader_User SET avatar = '$targetFile' WHERE username = '$username'";
                    if ($conn->query($updateSQL)) {
                        echo "Avatar updated successfully! Redirecting...";
                        echo "<script>setTimeout(() => window.location.href = '../profile.php', 3000);</script>";
                    } else {
                        echo "Database update failed.";
                    }
                } else {
                    echo "Failed to upload file.";
                }
            } else {
                echo "Invalid file type or size exceeds 2MB.";
            }
        }
    ?>
    </div>

    <!-- Hide the form if the form has submit -->
    <main style="<?php echo $showPHPHandle ? 'display: none;' : 'display: block;'; ?>">
        <div class="edit-container">
            <div class="edit-header">
                <h2>Change Avatar</h2>
            </div>

            <form class="formEdit" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <div class="oldAvatarContainer">
                <?php 
                    if ($user['avatar'] != null) {
                        echo "<img src='../".$user['avatar']."' alt='Profile Image'>";
                    } else {
                        echo '<div class="profile-picture">'.$user['username'][0].'</div>';
                    }
                ?>
                    <label>
                        Old Avatar
                    </label>                   
                </div>

                <label>
                    New Avatar: 
                    <input type="file" id="avatar" name="avatar" accept="image/*" required>
                </label>
                <input type="submit" class="confirm-btn" value="CONFIRM" id="confirmBtn">
            </form>
        </div>
    </main>

    <?php include("../footer.html"); ?>
</body>

</html>




