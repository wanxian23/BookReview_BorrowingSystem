<?php
include ('database/database.php');

$username = $_POST['username'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$newPassword = $_POST['newpassword']; 
$rePassword = $_POST['confirmpassword'];   

//  check: both password sama tak
if ($newPassword !== $rePassword) {
    echo "<script>
        alert('Passwords do not match.');
        window.location.href = '../forgotPassword.php';
    </script>";
    exit;
}


// Check if user exists
$sql = "SELECT * FROM users WHERE username=? AND email=? AND phone=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $email, $phone);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // User da jumpa → update password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $update = "UPDATE users SET password=? WHERE username=?";
    $updateStmt = $conn->prepare($update);
    $updateStmt->bind_param("ss", $hashedPassword, $username);

    if ($updateStmt->execute()) {
        echo "<script>
            alert('Password reset successful. You can now login!');
            window.location.href = '../login.php';
        </script>";
    } else {
        echo "<script>
            alert('Error updating password.');
            window.location.href = '../forgotPassword.php';
        </script>";
    }

} else {
    // No user match
    echo "<script>
        alert('User not found. Please check your details.');
        window.location.href = '../forgotPassword.php';
    </script>";
}
?>

