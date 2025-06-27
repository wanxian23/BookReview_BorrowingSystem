<?php
/*------------------------------------------
  borrowFormHandle.php
  Receives POST data from borrowForm.php
-------------------------------------------*/

// 1. connect to DB  (update path & creds)
include('../database/database.php');   //  <- file that sets up $conn (mysqli)

// 2. grab & sanitise POST data
$name        = trim($_POST['name']);
$phone       = trim($_POST['phone']);
$email       = trim($_POST['email']);
$address     = trim($_POST['address']);
$borrowDate  = $_POST['borrowDate'];
$returnDate  = $_POST['returnDate'];
$reason      = trim($_POST['reason'] ?? '');

// 3. basic PHP-side validation (optional but nice)
if (empty($name) || empty($phone) || empty($email) || empty($address)) {
    echo "<script>alert('Please fill in all required fields.');
          window.history.back();</script>";
    exit;
}

// 4. insert into database
$sql = "INSERT INTO borrow_request 
        (name, phone, email, address, borrow_date, return_date, reason)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss",
    $name, $phone, $email, $address, $borrowDate, $returnDate, $reason);

if ($stmt->execute()) {
    // success
    echo "<script>
            alert('Borrow request submitted! The owner will review it soon.');
            window.location.href='../index.php';   // or wherever you want
          </script>";
} else {
    // failure
    echo "<script>
            alert('Error submitting request. Please try again.');
            window.history.back();
          </script>";
}

$stmt->close();
$conn->close();
?>
