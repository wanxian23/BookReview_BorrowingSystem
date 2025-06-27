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

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();

$postCode = $_REQUEST['postCode'];
$commentCode = $_REQUEST['commentCode'];

$sqlGetComment = "SELECT
                    comment.*,
                    post.*,
                    reader.*,
                    bookBorrow.*
                  FROM Comment_Rating comment
                  INNER JOIN Post_Review post ON comment.postCode = post.postCode
                  INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
                  LEFT JOIN Book_Borrowed bookBorrow ON comment.bookBorrowCode = bookBorrow.bookBorrowCode
                  WHERE comment.postCode = '$postCode' AND
                  comment.commentCode = '$commentCode'";
$resultGetComemnt = $conn->query($sqlGetComment);
$userComment = $resultGetComemnt->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

    <?php include("headDetails.html"); ?>
    <title>Edit Username</title>

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

        main label.output {
            display: inline-block;
            font-size: 1.3em;
            width: 100%;
            text-align: center;
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
            width: 80%;
            font-size: 1.3em;
            text-align: left;
            font-weight: bold;
        }

        .formEdit input {
            padding: 0 5px;
        }

        .formEdit table th,
        .formEdit table td {
            padding: 10px 0;
        }

        .formEdit table th {
            width: 220px;
        }

        .phpHandle {
            display: none;
            justify-content: center;
            align-items: center;
            padding: 160px;
            font-size: 1.5em;           
        }

        textarea {
            width: 400px;
            padding: 3px 10px;
            min-height: 35px;
            resize: vertical;
        }
    </style>

    <script>
        $(document).ready(function() {
            $("#confirmBtn").click(function(event) {
                let username = document.getElementById("username").value;

                if (username === "") {
                    window.alert("Username Cannot Be Null!");
                    event.preventDefault();
                    return;
                }

                if (username.length > 16) {
                    window.alert("Username Cannot Exceed 16 Characters!");
                    event.preventDefault();
                    return;
                }
            });
        });
    </script>

</head>

<body>
    <?php include("header.php"); ?>

    <main>

    <?php 

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        $editComment = $_POST['editComment'];
        $editRating = $_POST['editRating'];

        $sql = "UPDATE Comment_Rating SET comment = '$editComment', rating = '$editRating' WHERE commentCode = '$commentCode'";
        $runSQL = $conn->query($sql);

        if ($runSQL) {
            echo "<label class='output'>Comment Edited Successfully! Back to post....</label>";

            // If u use meta, even has 3s load, but since it load every second
            // So u cant apply css (display show or hide)
            // U should use js to make delay
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '../bookDetail.php?postCode={$postCode}';
                    }, 3000);
                </script>";    
        } else {
            echo "<label class='output'>Failed To Edit Comment! Try Again!</label>";

            // If u use meta, even has 3s load, but since it load every second
            // So u cant apply css (display show or hide)
            // U should use js to make delay
            echo "<script>
                    setTimeout(function() {
                        window.location.href = '../ratingEdit.php?postCode={$postCode}';
                    }, 3000);
                </script>";            
        }
    } else {

    ?>

    <div class="edit-container">
        <div class="edit-header">
            <h2
                style="text-align: center; font-size: 1.6em;">Edit Comment
            </h2>
        </div>

        <form class="formEdit" action="<?php echo htmlspecialchars("ratingEdit.php?commentCode={$userComment['commentCode']}&postCode={$postCode}"); ?>" method="post">
            <table>
                <tr>
                    <th>
                        <p>
                            Old Comment:
                        </p> 
                    </th>
                    <td>
                        <label for="" style="font-weight: normal;"><?php echo $userComment['comment']; ?></label>
                    </td>
                </tr>
                <tr>
                    <th>
                        <p>
                            Old Rating:
                        </p>
                    </th>
                    <td>
                        <label for="" style="font-weight: normal;"><?php echo $userComment['rating']; ?> / 10</label>
                    </td>
                </tr>
                <tr>
                    <th>
                        <p>
                            New Comment : 
                        </p>
                    </th>
                    <td>
                        <label for="" style="font-weight: normal;"><textarea type="text" placeholder="Reply" id="editComment" name="editComment" autofocus required><?php echo $userComment['comment']; ?></textarea></label>
                    </td>
                </tr>
                <tr>
                    <th>     
                        <p>
                            New Rating : 
                        </p>
                    </th>
                    <td>
                    <label for="" style="font-weight: normal;"><input type="number" placeholder="Reply" id="editRating" name="editRating" value="<?php echo $userComment['rating']; ?>" autofocus required></label>
                    </td>
                </tr>
            </table>
            <input type="submit" class="confirm-btn" value="CONFIRM" id="confirmBtn">
        </form>

    </div> <?php } ?>

    </main>

    <?php include("../footer.html"); ?>
</body>

</html>