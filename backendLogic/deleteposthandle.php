<?php
session_start();
require("../database/database.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['post_id']) || !is_numeric($_POST['post_id'])) {
        $_SESSION['error_message'] = "Invalid post ID.";
        header("Location: ../profilemyposts.php");
        exit();
    }

    $post_id = intval($_POST['post_id']);
    $username = $_SESSION['username'];
    $email = $_SESSION['email'];
    $contact = $_SESSION['contact'];

    // Confirm the post belongs to the user
    $sql = "DELETE p FROM Posts p
            JOIN Reader_User u ON p.user_id = u.user_id
            WHERE p.post_id = ? AND (u.username = ? OR u.email = ? OR u.phone = ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $post_id, $username, $email, $contact);
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Post deleted successfully.";
    } else {
        $_SESSION['error_message'] = "Failed to delete post.";
    }

    $stmt->close();
    $conn->close();

    // Redirect back
    $redirect_to = isset($_POST['redirect_to']) ? $_POST['redirect_to'] : '../profilemyposts.php';
    header("Location: ../" . $redirect_to);
    exit();
} else {
    $_SESSION['error_message'] = "Invalid request method.";
    header("Location: ../profilemyposts.php");
    exit();
}
