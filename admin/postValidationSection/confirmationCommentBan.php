<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: ../login.php");
}

require("../../database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];
$readerID = $_SESSION['readerID'];

$sql = "SELECT * FROM admin WHERE adminUsername = '$username'
OR adminEmail = '$email' OR adminPhone = '$contact'";
$runSQL = $conn->query($sql);
$admin = $runSQL->fetch_assoc();

$postCode = $_REQUEST['postCode'];
$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      WHERE post.postCode = '$postCode'";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_assoc();


$commentCode = "";
if (isset($_REQUEST['commentCode'])) {

    $commentCode = $_REQUEST['commentCode'];

    $sqlGetComment = "SELECT        
                    comment.*,
                    post.*,
                    reader.*,
                    reader.readerID AS commentReaderID
                  FROM Comment_Rating comment
                  INNER JOIN Post_Review post ON comment.postCode = post.postCode
                  INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
                  WHERE comment.postCode = '$postCode'
                  AND comment.commentCode = '$commentCode'";
$resultGetComemnt = $conn->query($sqlGetComment);
$comment = $resultGetComemnt->fetch_assoc();
}


$nestedCommentCode = "";
if (isset($_REQUEST['nestedCommentCode'])) {

    $nestedCommentCode = $_REQUEST['nestedCommentCode'];
    $sqlGetNestedComment = "SELECT nestedComment.*,
    comment.commentCode,
    reader.*,
    reader.readerID nestedCommentReaderID
    FROM Nested_Comment_Rating nestedComment
    INNER JOIN Comment_Rating comment USING (commentCode)
    INNER JOIN Reader_User reader ON nestedComment.readerID = reader.readerID
    WHERE nestedComment.commentCode = '$nestedCommentCode
    '";
$resultsqlGetNestedComment = $conn->query($sqlGetNestedComment);
$nestedComment = $resultsqlGetNestedComment->fetch_assoc();

}


?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <?php include("headDetails.html"); ?>
    <title>Delete Post</title>

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

        .borrowForm {
            display: flex;
            flex-direction: column;
            gap: 30px;
            align-items: center;
        }

        .confirm-btn {
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
            border: none;
            padding: 12px 30px;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
        }

        .confirm-btn:hover {
            background-color: var(--buttonHoverColor);
        }

        .cancel-btn {
            background-color: transparent;
            color: var(--containerColor);
            border: 2px solid var(--containerColor);
            padding: 10px 20px;
            border-radius: 6px;
            font-weight: 600;
            text-decoration: none;
        }

        .cancel-btn:hover {
            background-color: #e0e0e0;
        }

        .field{margin-bottom:18px; width: 60%;}
        .field:first-child {text-align: center;}
        .field:first-child label {display:inline; background-color:rgb(230, 230, 230); padding: 10px; border-radius: 8px;}
        .field label{display:block;margin-bottom:6px;font-weight:500; font-size: 1.3em;}
        .field input,.field textarea, .field #deliveryMethod{width:100%;padding:12px;border:1px solid #ccc;
                                 border-radius:5px;font-size:15px;}
        textarea {
            min-height: 50px;
        }

    </style>
</head>
<body>

    <?php include("adminHeader.php"); ?>

    <main>

    <?php 

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $reason = trim($_POST['reasonBan']);
            
            if (isset($_REQUEST['commentCode'])) {

                $sqlUpdateStatusComment = "UPDATE Comment_Rating SET statusComment = 'BANNED', reasonBan = '$reason' WHERE commentCode = '$commentCode'";
                $resultUpdateStatusComment = $conn->query($sqlUpdateStatusComment);

                if ($resultUpdateStatusComment) {
                    echo "<label style='text-align: center;'>Comment Banned Successfully!</label>";
                    echo "<meta http-equiv='refresh' content='3; url=../adminBookDetail.php?postcode=$postCode'>";
                } else {
                    echo "<label style='text-align: center;'>Comment Failed To Ban!</label>";
                    echo "<meta http-equiv='refresh' content='3; url=../adminBookDetail.php?postcode=$postCode'>";
                }

            } else {

                $sqlUpdateStatusNestedComment = "UPDATE Nested_Comment_Rating SET statusComment = 'BANNED', reasonBan = '$reason'  WHERE nestedCommentCode = '$nestedCommentCode'";
                $resultUpdateStatusNestedComment = $conn->query($sqlUpdateStatusNestedComment);

                if ($resultUpdateStatusNestedComment) {
                    echo "<label style='text-align: center;'>Comment Banned Successfully!</label>";
                    echo "<meta http-equiv='refresh' content='3; url=../adminBookDetail.php?postcode=$postCode'>";
                } else {
                    echo "<label style='text-align: center;'>Comment Failed To Ban!</label>";
                    echo "<meta http-equiv='refresh' content='3; url=../adminBookDetail.php?postcode=$postCode'>";
                }

            }

        } else { ?>

        <div class="edit-container">
            <div class="edit-header">
                <h2 style="text-align: center; font-size: 1.6em;">Comment Ban Confirmation</h2>
            </div>

            <?php
            
            if (isset($_REQUEST['commentCode'])) {
                echo '<form id="borrowForm" class="borrowForm" method="POST" action="'.htmlspecialchars("confirmationCommentBan.php?postCode=$postCode&commentCode=$commentCode").'">';
            } else {
                echo '<form id="borrowForm" class="borrowForm" method="POST" action="'.htmlspecialchars("confirmationCommentBan.php?postCode=$postCode&nestedCommentCode=$nestedCommentCode").'">';
            }
            ?>

                <?php 

                    if (isset($_REQUEST['commentCode'])) {
                        echo '<p style="font-size: 1.3em; background-color: lightgray; padding: 10px 20px; border-radius: 5px; text-align: center; line-height: 1.5;">';
                        echo 'User <b>\'' . $comment['username'] . '\'</b> Has Commented As Below:<br>';
                        echo "<b>'{$comment['comment']}'</b>";
                        echo '</p>';
                        
                        echo '<p style="font-size: 1.3em; text-align: center; line-height: 1.5;">';
                        echo '<label style="color: red;">Are You Confirm To Ban This Comment?</label>';
                        echo '</p>';                        
                    } else {
                        
                    }
                ?>

                <div class="field">
                    <label for="address">Reason Ban</label>
                    <textarea id="reasonBan" name="reasonBan" placeholder="Reason Ban/ Message Warning" required></textarea>
                </div>

                <input type="hidden" name="postCode" value="<?php echo $postCode; ?>">
                <div style="display: flex; gap: 20px;">
                    <button type="submit" class="confirm-btn">Yes, Ban</button>
                    <a href="../adminBookDetail.php?postCode=<?php echo $postCode; ?>" class="cancel-btn">Cancel</a>
                </div>

            </form>
        </div>

        <?php } ?>
    </main>

    <?php include("../../footer.html"); ?>

    <script>
</script>
</body>
</html>