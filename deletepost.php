<?php
session_start();
require("../database/database.php");

if (!isset($_GET['postCode'])) {
    $_SESSION['error_message'] = "Post ID not provided.";
    header("Location: ../profilemyposts.php");
    exit();
}

$post_id = intval($_GET['postCode']);
$redirect_to = isset($_GET['redirect_to']) ? $_GET['redirect_to'] : "../profilemyposts.php";

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];

$sql_check = "SELECT p.post_id
              FROM Posts p
              JOIN Reader_User u ON p.user_id = u.user_id
              WHERE p.post_id = ? AND (u.username = ? OR u.email = ? OR u.phone = ?)";

$stmt = $conn->prepare($sql_check);
$stmt->bind_param("isss", $post_id, $username, $email, $contact);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error_message'] = "You do not have permission to delete this post.";
    header("Location: $redirect_to");
    exit();
}

// Delete post
$sql_delete = "DELETE FROM Posts WHERE post_id = ?";
$stmt_del = $conn->prepare($sql_delete);
$stmt_del->bind_param("i", $post_id);
$stmt_del->execute();

$_SESSION['success_message'] = "Post deleted successfully.";
header("Location: $redirect_to");
exit();
?>
