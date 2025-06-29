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

$borrowID = $_REQUEST['readerID'];
$sqlBorrowerDetails = "SELECT *
                      FROM book_borrowed borrow
                      INNER JOIN reader_user USING (readerID)
                      WHERE postCode = '$postCode'
                      AND borrow.readerID = '$borrowID'";
$resultGetBorrowerDetails = $conn->query($sqlBorrowerDetails);
$borrower = $resultGetBorrowerDetails->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en"
      data-themeColor="defaultColor"
      data-fontSize="defaultFontSize">

<head>
  <?php include "headDetails.html"; ?>
  <title>General Request Form</title>

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
    .form-box{background:var(--formBg);color:var(--formCol);width:45%;
              border-radius:10px;box-shadow:var(--shadow);}
    .header{padding:20px 0;text-align:center;font-size:24px;font-weight:bold;
            border-bottom:1px solid #ddd;}
    .body{padding:25px 35px;}
    .field{margin-bottom:18px; display: flex; flex-direction: column;}
    .field:first-child {margin-bottom:30px; text-align: center;}
    .field:first-child label {background-color:rgb(230, 230, 230); padding: 10px; border-radius: 8px; word-break: break-all;}
    .field label{display:block;margin-bottom:6px;font-weight:500;}
    .field input,.field textarea{width:100%;padding:12px;border:1px solid #ccc;
                                 border-radius:5px;font-size:15px;}
    a.submit{
        width:100%;
        padding:14px;
        border:none;
        border-radius:5px;
        background-color:rgb(186, 180, 242);
        color: black;
        font-size: 1.2em;
        cursor:pointer;
        text-decoration: none;
        text-align: center;
        box-shadow: var(--shadow);
        transition: 0.2s;
    }

    a.submit:hover {
        background-color:rgb(206, 203, 234);
    }
        
    input[type="submit"]:hover{
        background:var(--btnBgH);
    }
    @media(max-width:650px){.form-box{width:90%;}}

    .profile-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 235px; 
            margin: 30px auto;
            width: 50%;
        }

        .profile-left {
            display: flex;
            flex-direction: column; 
            align-items: center;
            justify-content: center;
        }

        .borrower-profile-left {
            width:100%;
            display: flex; 
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .borrower-profile-left div:first-child {
            display: flex; 
            align-items: center;
            gap: 20px;
        }

        .borrower-profile-left div:last-child {
            display: flex; 
            align-items: center;
            gap: 20px;
        }

        .borrower-profile-left div:last-child label {
            color: red;
            width: 400px;
            word-wrap: break-word;
        }

        .borrower-profile-left div:last-child a {
            padding: 5px 0;
            text-align: center;
            width: 100px;
            background-color:rgb(186, 180, 242);
            border-radius: 5px;
            transition: 0.2s;
            text-decoration: none;
            border: 2px solid;
            color: black;
        }

        .borrower-profile-left div:last-child a:hover {
            background-color:rgb(206, 203, 234);
        }

        .profile-left img, .borrower-profile-left img {
            width: 110px;
            height: 110px; 
            border-radius: 50%;
            border: 8px solid black;          
        }

        .profile-picture {
            width: 110px;
            height: 110px;
            background: #e0c5ff;
            border-radius: 50%;
            font-size: 24px;
            font-weight: bold;
            color: black;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 8px solid black;
        }

        .profile-name {
            font-size: 35px;
            font-weight: bold;
        }

        .editProfile {
            max-width: 900px;
            margin: auto;
            padding: 20px;
            border-radius: 12px;
            background-color: var(--containerBgColor);
            color: var(--containerColor);
            box-shadow: var(--bookBoxShadow);
        }
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

    <div class="header">Borrow Request Form (General)</div>
    <div class="body">
    <?php
           echo '<div class="borrower-profile-left">';
    
           echo '<div>';
           if (!empty($borrower['avatar'])) {
               echo "<img class='borrowerProfile' data-readerID='{$borrower['readerID']}' data-postCode='{$post['postCode']}' src='" . $borrower['avatar'] . "' alt='Profile Image'>";
           } else {
               echo "<div class='profile-picture borrowerProfile' data-readerID='{$borrower['readerID']}' data-postCode='{$post['postCode']}'>" . strtoupper($borrower['username'][0]) . "</div>";
           }
           echo '<div class="profile-name">' . htmlspecialchars($borrower['username']) . '</div>';
           echo '</div>';
           echo "<div class='field' style='text-align: center; margin: 20px auto; background-color: lightgray; border-radius: 8px; padding: 10px 30px; display: inline-block;'>
           <label for=''>This General Borrow Request Form Is Answered By <b>'{$borrower['username']}'</b><br>For Borrow Book <b>'{$post['bookTitle']}'</b></label>
       </div>";   
           echo '</div>';
    ?>

      <div class="field">
        <label for="address">General Address</label>
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

      <div class="field" style="flex-direction: row; gap: 20px; justify-content: center; font-size: 1.3em; color: red; text-align: center;">
           <?php
                if ($borrower['statusBorrow'] === "PENDING") {
                    echo '<a class="submit" href="backendLogic/bookApprovalHandling.php?postCode='.$post['postCode'].'&borrowerReaderID='.$borrower['readerID'].'">Approve</a>';
                    echo '<a class="submit" href="backendLogic/bookRejectionHandling.php?postCode='.$post['postCode'].'&borrowerReaderID='.$borrower['readerID'].'">Reject</a>';
                } else if ($borrower['statusBorrow'] === "APPROVED") {
                    echo '<div>You Have Approved <b>\''.$borrower['username'].'\'</b><br>To Borrow Book <b>\''.$post['bookTitle'].'\'</b></div>';
                } else {
                    echo '<div>You Have Rejected <b>\''.$borrower['username'].'\'</b><br>To Borrow Book <b>\''.$post['bookTitle'].'\'</b></div>';
                }
           ?>
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

  
  $(".borrowerProfile").click(function() {
    let postCode = this.getAttribute("data-postCode");
    let readerID = this.getAttribute("data-readerID");
    window.location.href = "viewUsersProfile.php?postCode=" + postCode + "&readerID=" + readerID;               
   });
});
</script>
</body>
</html>
