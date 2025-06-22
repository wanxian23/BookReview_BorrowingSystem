<?php
session_start();

require("../database/database.php");

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: ../login.php");
    exit();
}

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];

$postCode = isset($_REQUEST['postCode']) ? $_REQUEST['postCode'] : null;

if (!$postCode) {
    $_SESSION['error_message'] = "Post code missing.";
    header("Location: ../bookDetail.php");
    exit();
}

$sql = "SELECT post.postCode, post.readerID 
        FROM post_review post
        INNER JOIN reader_user reader ON post.readerID = reader.readerID
        WHERE post.postCode = ? AND (reader.username = ? OR reader.email = ? OR reader.phone = ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $postCode, $username, $email, $contact);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = "You do not have permission to delete this post.";
    header("Location: ../bookDetail.php?postCode=" . urlencode($postCode));
    exit();
}
$stmt->close();

$deleteSQL = "DELETE FROM post_review WHERE postCode = ?";
$stmtDelete = $conn->prepare($deleteSQL);
$stmtDelete->bind_param("i", $postCode);

if ($stmtDelete->execute()) {
    $_SESSION['success_message'] = "Post deleted successfully.";
    header("Location: ../profilemyposts.php");
} else {
    $_SESSION['error_message'] = "Failed to delete post.";
    header("Location: ../bookDetail.php?postCode=" . urlencode($postCode));
}
$stmtDelete->close();
$conn->close();
?>
