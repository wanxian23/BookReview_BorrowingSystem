<?php
session_start();

require("../database/database.php");

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

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <?php include("headDetails.html"); ?>
    <title>Redirecting..</title>

    <style>
        
        main {
            text-align: center;
            margin: 5% 6%;
            font-size: 1.3em;
        }

    </style>
</head>
<body>

    <?php include("header.php"); ?>

    <main>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postCode = isset($_POST['postCode']) ? intval($_POST['postCode']) : null;
      
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $contact = $_SESSION['contact'];

   if (!$postCode) {
       $_SESSION['error_message'] = "Post code missing.";
       header("Location: ../bookDetail.php");
       exit();
    } 

    $sql = "SELECT post.postCode
        FROM post_review post
        INNER JOIN reader_user reader ON post.readerID = reader.readerID
        WHERE post.postCode = ? AND (reader.username = ? OR reader.email = ? OR reader.phone = ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $postCode, $username, $email, $contact);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        $_SESSION['error_message'] = "You do not have permission to delete this post.";
        echo "<meta http-equiv='refresh' content='3; url=../bookDetail.php?postCode=" . urlencode($postCode)."'>";
        exit();
    }

    $stmt->close();

    $deleteSQL = "DELETE FROM post_review WHERE postCode = ?";
    $stmtDelete = $conn->prepare($deleteSQL);
    $stmtDelete->bind_param("i", $postCode);
   
    if ($stmtDelete->execute()) {
        echo "Post deleted successfully.";
        echo "<meta http-equiv='refresh' content='3; url=../profilemyposts.php'>";
    }else {
        echo "Failed to delete post.";
        echo "<meta http-equiv='refresh' content='3; url=../bookDetail.php?postCode=" . urlencode($postCode)."'>";
    }   
    
   $stmtDelete->close();
   $conn->close();
}
?>

</main>

<?php include("../footer.html"); ?>

</body>
</html>
