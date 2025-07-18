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
$sqlAllPost = "SELECT 
                post.*,
                reader.*,
                book.*
            FROM post_review post
            INNER JOIN reader_user reader USING (readerID)
            INNER JOIN book_record book USING (bookID)
            WHERE post.postCode = '$postCode'";
$runSQLAllPost = $conn->query($sqlAllPost);
$post = $runSQLAllPost->fetch_assoc();

$borrowReaderID = $_REQUEST['borrowerReaderID'];
$sqlBorrowerDetails = "SELECT
borrow.*,
reader.*
FROM Book_Borrowed borrow
INNER JOIN Reader_User reader USING (readerID)
WHERE borrow.postCode = '$postCode'
AND borrow.readerID = '$borrowReaderID'";
$resultBorrowDetails = $conn->query($sqlBorrowerDetails);
$borrow = $resultBorrowDetails->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <?php include("headDetails.html"); ?>
    <title>Logout</title>

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
            display: flex;
            justify-content: center;
            margin: 5% 6%;
        }

        main .statusNote {
            font-size: 1.2em;
        }

        .review-container {
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            box-shadow: var(--containerBoxShadow);
            border-radius: 12px;
            padding: 50px;
            max-width: 1000px;
            width: 100%;
            margin: 0 auto;
        }

        .review-container div:nth-child(2) {
            display: flex;
            flex-direction: column;
            justify-content: center;
            gap: 30px;
            align-items: center;
        }

        .review-container div:nth-child(2) label {
            font-size: 1.4em;
        }

        #rejectForm {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }

        #rejectForm div {
            display: flex;
            gap: 20px;
        }

        #rejectForm div textarea {
            resize: vertical;
            width: 300px;
            padding: 5px 10px;
        }

        .review-header {
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
        }

        .confirm-btn:hover {
            background-color: var(--buttonHoverColor);
        }

        .confirm-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }
    </style>

</head>
<body>

    <?php include("header.php"); ?>

    <main>

    <?php

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            $postCode = $_REQUEST['postCode'];
            $borrowReaderID = $_REQUEST['borrowerReaderID'];

            $sqlReject = "UPDATE book_borrowed SET statusBorrow = 'REJECTED' WHERE postCode = '$postCode' AND readerID = '$borrowReaderID'";
            $resultSqlReject = $conn->query($sqlReject);

            if ($resultSqlReject) {
                echo "<label class='statusNote'>Book Request Rejected Successfully!</label>";
                echo "<meta http-equiv='refresh' content='3 ;url=../borrowDetails.php?section=borrowRequest&sectionAside=rejectBorrowRequest'>";
            } else {
                echo "<label class='statusNote'>Failed To Reject Book Request!</label>";
                echo "<meta http-equiv='refresh' content='3 ;url=../bookDetail.php?postCode=".$postCode."'>";
            }

        } else {
    ?>
        <div class="review-container">
            <div class="review-header">
                <h2 class="review-success"
                    style="text-align: center; font-size: 1.6em;">Book Request Rejection Confirmation
                </h2>
            </div>

            <div>
                <p
                    style="display: inline-block; margin-bottom: auto; margin-top:auto; font-weight: bold; text-align: center; font-size: 1.6em;">
                    Reject This Borrow Request?
                </p>
                <label for="" style="background-color: lightgray; padding: 10px 20px; border-radius: 10px;">'<?php echo $post['bookTitle'] ?>' That Requested By '<?php echo $borrow['username'] ?>'</label>
            </div>


            <form id="rejectForm" method="POST" class="confirm-container" action="<?php echo htmlspecialchars("bookRejectionHandling.php?postCode=".$postCode."&borrowerReaderID=".$borrowReaderID); ?>">
                <input type="submit" class="confirm-btn" value="REJECT">
            </form>

        </div>


        </form>
        </div>

        <?php } ?>

    </main>

    <?php include("../footer.html"); ?>

</body>
</html>