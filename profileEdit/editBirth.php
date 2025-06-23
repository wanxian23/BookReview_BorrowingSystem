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
    <title>Edit Date of Birth</title>

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
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--containerColor);
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
                let birth = document.getElementById("birth").value;

                if (birth === "") {
                    window.alert("Date of Birth Cannot Be Null!");
                    event.preventDefault();
                    return;
                }
                // Initial format is YYYY-MM-DD
                // So, split it by - to get year (index 0)
                let birthYear = parseInt(birth.split("-")[0]);

                if (birthYear < 1910 || birthYear > 2025) {
                    window.alert("Birth Year Can Only In The Range 1910 To 2025!");
                    return false;
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

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $readerID = $_SESSION['readerID'];
        $newBirth = $_POST['birth'];

        $sql = "UPDATE Reader_User SET dateOfBirth = '$newBirth' WHERE readerID = '$readerID'";
        $runSQL = $conn->query($sql);

        if ($runSQL) {
            echo "Date Of Birth Changed Successfully! Back to profile....";

            // If u use meta, even has 3s load, but since it load every second
            // So u cant apply css (display show or hide)
            // U should use js to make delay
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '/BookReview_BorrowingSystem/profile.php';
                    }, 3000);
                </script>";    
        }
    }

    ?>
    </div>

    <!-- Hide the form if the form has submit -->
    <main style="<?php echo $showPHPHandle ? 'display: none;' : 'display: block;'; ?>">
        <div class="edit-container">
            <div class="edit-header">
                <h2
                    style="text-align: center; font-size: 1.6em;">Edit Date of Birth
                </h2>
            </div>

            <form class="formEdit" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <p>
                    Old Date of Birth: <label for="" style="font-weight: normal;"><?php echo $user['dateOfBirth']; ?></label>
                </p>

                <p>
                    New Date of Birth: <label for="" style="font-weight: normal;"><input type="date" placeholder="New Contact Num" id="birth" name="birth" autofocus required></label>
                </p>

                <input type="submit" class="confirm-btn" value="CONFIRM" id="confirmBtn">
            </form>

        </div>


        </form>
        </div>

    </main>

    <?php include("../footer.html"); ?>
</body>

</html>