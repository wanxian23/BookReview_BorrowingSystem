<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];
$readerID = $_SESSION['readerID'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();


$postCode = $_REQUEST['postCode'];
$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*,
                          borrow.statusBorrow
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      LEFT JOIN book_borrowed borrow USING (postCode)
                      WHERE post.postCode = '$postCode'";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_assoc();


$sqlBorrowerDetails = "SELECT *
                      FROM book_borrowed borrow
                      INNER JOIN reader_user USING (readerID)
                      WHERE postCode = '$postCode'";
$resultGetBorrowerDetails = $conn->query($sqlBorrowerDetails);
$borrower = $resultGetBorrowerDetails->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en"
      data-themeColor="defaultColor"
      data-fontSize="defaultFontSize">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Borrow Request Form</title>

  <!-- icon & js libs -->
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

  <!-- main shared stylesheet -->
  <link rel="stylesheet" href="style.css">
  <link rel="icon" href="image/logo.png">

  <!-- small page-specific css (inherits colour vars from style.css) -->
  <style>
    :root{
      --formBg:  var(--loginContainerBgColor,white);
      --formCol: var(--loginContainerColor,black);
      --btnBg:   var(--loginContainerButtonBgColor,#333);
      --btnCol:  var(--loginContainerButtonColor,#fff);
      --btnBgH:  var(--loginContainerButtonHoverBgColor,#444);
      --shadow:  var(--loginContainerBoxShadow,1px 1px 10px rgba(0,0,0,.25));
    }
    main{display:flex;justify-content:center;align-items:center;padding:70px 0;}
    .form-box{background:var(--formBg);color:var(--formCol);width:45%;margin: 0 auto;
              border-radius:10px;box-shadow:var(--shadow);}
    .header{padding:20px 0;text-align:center;font-size:24px;font-weight:bold;
            border-bottom:1px solid #ddd;}
    .body{padding:25px 35px;}
    .field{margin-bottom:18px;}
    .field:first-child {margin-bottom:30px; text-align: center;}
    .field:first-child label {background-color:rgb(230, 230, 230); padding: 10px; border-radius: 8px; word-break: break-all;}
    .field label{display:block;margin-bottom:6px;font-weight:500;}
    .field input,.field textarea{width:100%;padding:12px;border:1px solid #ccc;
                                 border-radius:5px;font-size:15px;}
    input[type="submit"]{width:100%;padding:14px;border:none;border-radius:5px;
           background:var(--btnBg);color:var(--btnCol);font-size:16px;cursor:pointer;}
           input[type="submit"]:hover{background:var(--btnBgH);}
    @media(max-width:650px){.form-box{width:90%;}}
  </style>

  <!-- quick JS validation
  <script>
    function validateBorrow(){
      const phone=document.getElementById('phone').value.trim();
      const s=document.getElementById('borrowDate').value;
      const e=document.getElementById('returnDate').value;
      if(!/^\d{10,15}$/.test(phone)){alert("Phone number must be 10-15 digits.");return false;}
      if(s && e && e<s){alert("Return date can’t be earlier than borrow date.");return false;}
      return true;
    }
  </script> -->
</head>

<body>
    
    <?php include("header.php"); ?>

<main>
  <form id="borrowForm" class="form-box"
        action="<?php echo htmlspecialchars("backendLogic/borrowFormHandle.php?postCode=$postCode"); ?>"
        method="POST"
        onsubmit="return validateBorrow();">

    <div class="header">Borrow Request Form (View)</div>
    <div class="body">
    <?php
      echo "<div class='field'>
              <label for=''>This Borrow Form Is Answered By <b>'{$borrower['username']}'</b><br>For Borrow Book <b>'{$post['bookTitle']}'</b></label>
            </div>";
    ?>

      <div class="field">
        <label for="name">Full Name</label>
        <input type="text" id="name" name="name" value="<?php echo $borrower['fullname']; ?>" readonly>
      </div>

      <div class="field">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" value="<?php echo $borrower['phone']; ?>" readonly>
      </div>

      <div class="field">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" value="<?php echo $borrower['email']; ?>" readonly>
      </div>

      <div class="field">
        <label for="address">Full Address</label>
        <textarea id="address" name="address" rows="3" readonly><?php echo $borrower['address']; ?></textarea>
      </div>

      <div class="field">
      <label for="email">Delivery Method</label>
      <input type="text" id="deliveryMethod" name="deliveryMethod" value="<?php echo $borrower['deliveryMethod']; ?>" readonly>
    </div>

      <div class="field">
        <label for="borrowDate">Preferred Borrow Date</label>
        <input type="date" id="borrowDate" name="borrowDate" value="<?php echo date('Y-m-d', strtotime($borrower['borrowDate'])); ?>" readonly>
      </div>

      <div class="field">
        <label for="returnDate">Expected Return Date</label>
        <input type="date" id="returnDate" name="returnDate" value="<?php echo date('Y-m-d', strtotime($borrower['expectedReturnDate'])); ?>" readonly>
      </div>

      <div class="field">
        <label for="reason">Reason for Borrowing (optional)</label>
        <textarea id="reason" name="reason" rows="2" readonly><?php echo $borrower['reasonBorrow']; ?></textarea>
      </div>
    </div>
  </form>
</main>

<?php include("footer.html") ?>

<script>
$(document).ready(function () {
  $("#borrowForm").submit(function (event) {
    const borrowDate = new Date(document.getElementById('borrowDate').value);
    const returnDate = new Date(document.getElementById('returnDate').value);
    const today = new Date();

    // Strip time from today
    today.setHours(0, 0, 0, 0);
    borrowDate.setHours(0, 0, 0, 0);
    returnDate.setHours(0, 0, 0, 0);

    if (borrowDate.getTime() <= today.getTime() && returnDate.getTime() <= today.getTime()) {
      event.preventDefault();
      alert("Borrow date must be after today.");
      return;
    }

    if (returnDate.getTime() <= borrowDate.getTime()) {
      event.preventDefault();
      alert("Return date must be after borrow date.");
      return;
    }
  });
});
</script>
</body>
</html>
