<?php
session_start();
require("../database/database.php");

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: ../login.php");
    exit();
}

if (!isset($_GET['postCode']) || empty($_GET['postCode'])) {
    $_SESSION['error_message'] = "Post code is missing.";
    header("Location: ../bookDetail.php");
    exit();
}

$postCode = $_GET['postCode'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];

// Validate ownership of the post
$sql = "SELECT post.postCode FROM post_review post
        JOIN reader_user reader ON post.readerID = reader.readerID
        WHERE post.postCode = ? AND (reader.username = ? OR reader.email = ? OR reader.phone = ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $postCode, $username, $email, $contact);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = "You do not have permission to delete this post.";
    $stmt->close();
    $conn->close();
    header("Location: ../bookDetail.php");
    exit();
}
$stmt->close();

// Delete related threads (if any)
$sqlDeleteThreads = "DELETE FROM thread_post WHERE postCode = ?";
$stmtDeleteThreads = $conn->prepare($sqlDeleteThreads);
$stmtDeleteThreads->bind_param("s", $postCode);
$stmtDeleteThreads->execute();
$stmtDeleteThreads->close();

// Delete post
$sqlDeletePost = "DELETE FROM post_review WHERE postCode = ?";
$stmtDeletePost = $conn->prepare($sqlDeletePost);
$stmtDeletePost->bind_param("s", $postCode);
$stmtDeletePost->execute();
$stmtDeletePost->close();

$conn->close();

$_SESSION['success_message'] = "Post deleted successfully.";
header("Location: ../bookDetail.php");
exit();
?>
