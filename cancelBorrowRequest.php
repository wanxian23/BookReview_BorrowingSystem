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

        .formDelete {
            display: flex;
            flex-direction: column;
            gap: 20px;
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

    </style>
</head>
<body>

    <?php include("header.php"); ?>

    <main>
        <div class="edit-container">
            <div class="edit-header">
                <h2 style="text-align: center; font-size: 1.6em;">Book Borrow Cancellation Confirmation</h2>
            </div>

            <form class="formDelete" method="POST" action="<?php echo htmlspecialchars("backendLogic/cancelBorrowRequestHandling.php?postCode=$postCode"); ?>">
                <p style="font-size: 1.3em;">Are you sure you want to cancel your book borrow request for this book?</p>
                <p style="font-size: 1.3em; background-color: lightgray; padding: 10px 20px; border-radius: 5px;">'<?php echo $post['bookTitle']; ?>' From User '<?php echo $post['username'] ?>'</p>
                <input type="hidden" name="postCode" value="<?php echo $postCode; ?>">
                <div style="display: flex; gap: 20px;">
                    <button type="submit" class="confirm-btn">Yes, Cancel</button>
                    <a href="bookDetail.php?postCode=<?php echo $postCode; ?>" class="cancel-btn">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <?php include("footer.html"); ?>

</body>
</html>