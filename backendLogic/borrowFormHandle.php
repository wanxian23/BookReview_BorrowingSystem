<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("../database/database.php");

$username = $_SESSION['username'];
$email = trim($_SESSION['email']);
$contact = trim($_SESSION['contact']);
$readerID = $_SESSION['readerID'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();


$postCode = $_REQUEST['postCode'];

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
            font-size: 1.3em;
        }
        </style>

</head>
<body>

    <?php include("header.php"); ?>

    <main>

    <?php

        if ($_SERVER['REQUEST_METHOD'] == "POST") {

            // ambil data POST
            $name       = $_POST['name']       ?? '';
            $phone      = $_POST['phone']      ?? '';
            $email      = $_POST['email']      ?? '';
            $address    = $_POST['address']    ?? '';

            // (optional) semak kosong
            if (!$name || !$phone || !$email || !$address) {
                echo "<script>alert('Isi semua ruang wajib.');history.back();</script>";
                exit;
            }

            // masukkan ke table `borrow_request`
            $sql = "UPDATE book_borrowed
                    SET fullname = ?, phone = ?, email = ?, address = ?
                    WHERE postCode = '$postCode' AND readerID = '$readerID'";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss",
                $name, $phone, $email, $address);

                $sqlGetBorrowRequestInfo = "SELECT * FROM book_borrowed
                                            WHERE postCode = '$postCode' AND readerID = '$readerID'
                                            ORDER BY bookBorrowCode DESC LIMIT 1";
                $resultGetBorrowRequestInfo = $conn->query($sqlGetBorrowRequestInfo);
                $borrowRequest = $resultGetBorrowRequestInfo->fetch_assoc();

                $sqlUpdatePostBorrowAvailability = "UPDATE post_review SET statusPostBorrow = 'NO' WHERE postCode = '{$borrowRequest['postCode']}'";
                $resultUpdatePostBorrowAvailability = $conn->query($sqlUpdatePostBorrowAvailability);

            if ($stmt->execute() && $resultUpdatePostBorrowAvailability) {
                echo "Borrow Request Form Submitted Successfully!";
                echo "<meta http-equiv='refresh' content='3 ;url=../borrowDetails.php?section=actionNeeded&sectionAside=toComplete'>";
            } else {
                echo "Borrow Request Form Failed To Submit!";
                echo "<meta http-equiv='refresh' content='3 ;url=../borrowDetails.php?section=actionNeeded&sectionAside=toComplete'>";
            }

        } ?>

</main>

<?php include("../footer.html"); ?>

</body>
</html>
