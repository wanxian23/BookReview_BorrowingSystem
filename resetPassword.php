<?php
// Show errors for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Step 1: Connect to your database
include '../db_connect.php'; // Adjust the path if needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Step 2: Get data from form
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $new_password = $_POST['new_password'];

    // Step 3: Basic check
    if (empty($username) || empty($email) || empty($phone) || empty($new_password)) {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit();
    }

    // Step 4: Search for matching user
    $query = "SELECT * FROM users WHERE username=? AND email=? AND phone=?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sss", $username, $email, $phone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Step 5: User found — update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        $update = "UPDATE users SET password=? WHERE username=?";
        $update_stmt = $conn->prepare($update);
        $update_stmt->bind_param("ss", $hashed_password, $username);

        if ($update_stmt->execute()) {
            echo "<script>alert('Password successfully reset! Please log in.'); window.location.href='../login.php';</script>";
        } else {
            echo "<script>alert('Something went wrong updating the password.'); window.history.back();</script>";
        }

        $update_stmt->close();
    } else {
        // No user found
        echo "<script>alert('No user found with those details.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect if accessed directly
    header("Location: ../forgot_password.php");
    exit();
}
?>
