<?php
include('../database/database.php');

// ambil data POST
$name       = $_POST['name']       ?? '';
$phone      = $_POST['phone']      ?? '';
$email      = $_POST['email']      ?? '';
$address    = $_POST['address']    ?? '';
$borrowDate = $_POST['borrowDate'] ?? '';
$returnDate = $_POST['returnDate'] ?? '';
$reason     = $_POST['reason']     ?? '';

// (optional) semak kosong
if (!$name || !$phone || !$email || !$address) {
    echo "<script>alert('Isi semua ruang wajib.');history.back();</script>";
    exit;<?php
include('../database/database.php');

// ambil data POST
$name       = $_POST['name']       ?? '';
$phone      = $_POST['phone']      ?? '';
$email      = $_POST['email']      ?? '';
$address    = $_POST['address']    ?? '';
$borrowDate = $_POST['borrowDate'] ?? '';
$returnDate = $_POST['returnDate'] ?? '';
$reason     = $_POST['reason']     ?? '';

// (optional) semak kosong
if (!$name || !$phone || !$email || !$address) {
    echo "<script>alert('Isi semua ruang wajib.');history.back();</script>";
    exit;
}

// masukkan ke table `borrow_request`
$sql = "INSERT INTO borrow_requests
        (name, phone, email, address, borrow_date, return_date, reason)
        VALUES (?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss",
    $name, $phone, $email, $address, $borrowDate, $returnDate, $reason);

if ($stmt->execute()) {
    echo "<script>alert('Request submitted!');location.href='../borrowForm.php';</script>";
} else {
    echo "<script>alert('Error, cuba lagi.');history.back();</script>";
}
?>

}

// masukkan ke table `borrow_requests`
$sql = "INSERT INTO borrow_request
        (name, phone, email, address, borrow_date, return_date, reason)
        VALUES (?,?,?,?,?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss",
    $name, $phone, $email, $address, $borrowDate, $returnDate, $reason);

if ($stmt->execute()) {
    echo "<script>alert('Request submitted!');location.href='../borrowForm.php';</script>";
} else {
    echo "<script>alert('Error, cuba lagi.');history.back();</script>";
}
?>
