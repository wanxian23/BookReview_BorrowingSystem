<?php

$sqlGetPostDetailsHeader = "SELECT 
post.*,
reader.*,
book.*
FROM post_review post
INNER JOIN reader_user reader USING (readerID)
INNER JOIN book_record book USING (bookID)
WHERE post.readerID = '$readerID'
AND post.statusApprove = 'APPROVED'
ORDER BY post.postCode DESC";
$resultGetPostDetailsHeader = $conn->query($sqlGetPostDetailsHeader);
$getPost = $resultGetPostDetailsHeader->fetch_all(MYSQLI_ASSOC);


$sqlGetCommentDetailsHeader = "SELECT nestedComment.*,
comment.*, post.statusPostBorrow
FROM Nested_Comment_Rating nestedComment
INNER JOIN Comment_Rating comment USING (commentCode)
INNER JOIN post_review post ON comment.postCode = post.postCode
WHERE comment.readerID = '$readerID'
AND post.statusApprove = 'APPROVED'";
$resultGetCommentDetailsHeader = $conn->query($sqlGetCommentDetailsHeader);
$commentDetailsHeader = $resultGetCommentDetailsHeader->fetch_all(MYSQLI_ASSOC);

    $sqlGetBorrowNotiHeader = "SELECT borrow.readerID AS borrowerID, post.*,
        borrow.statusBorrow, borrow.fullname, 
        book.bookTitle
    FROM book_borrowed borrow
    INNER JOIN Post_Review post USING (postCode)
    INNER JOIN Reader_User reader ON reader.readerID = borrow.readerID
    INNER JOIN book_record book USING (bookID)
    WHERE post.readerID = '$readerID'
    AND post.statusPostBorrow != 'BANNED'";
    $resultGetBorrowNotiHeader = $conn->query($sqlGetBorrowNotiHeader);
    $borrowNoti = $resultGetBorrowNotiHeader->fetch_all(MYSQLI_ASSOC);


    $sqlGetBorrowNotiHeader2 = "SELECT post.readerID AS ownerID, post.*,
    borrow.statusBorrow, borrow.fullname, reader.*,
    book.bookTitle
    FROM book_borrowed borrow
    INNER JOIN Post_Review post USING (postCode)
    INNER JOIN Reader_User reader ON reader.readerID = borrow.readerID
    INNER JOIN book_record book USING (bookID)
    WHERE borrow.readerID = '$readerID'
    AND post.statusPostBorrow != 'BANNED'";
    $resultGetBorrowNotiHeader2 = $conn->query($sqlGetBorrowNotiHeader2);
    $borrowNoti2 = $resultGetBorrowNotiHeader2->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

<title></title>

</head>

<body>
    <header>
        <div id="firstHeader">
            <a href="main.php" id="logo"><img src="image/logoTitle.png" alt="logo" id="logoImage"></a>

            <nav>
                <div>
                    <span class="colorButton"><label for="color">Color<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility colorAccessibility">
                        <div class="default option" data-color="defaultColor">Default</div>
                        <div class="option" data-color="lightColor">Light</div>
                        <div class="option" data-color="darkColor">Dark</div>
                    </div>
                </div>

                <div>
                    <span class="fontSizeButton"><label for="fontSize">Font Size<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility fontSizeAccessibility">
                        <div class="option" data-setFontSize="smallFontSize">Small</div>
                        <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                        <div class="option" data-setFontSize="largeFontSize">Large</div>
                        <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
                    </div>
                </div>
                <div>
                    <span class="supportButton"><label for="support">Support<box-icon name='chevron-down'
                                class="downArrow"></box-icon></label></span>
                    <div class="accessibility support">
                        <span style="color: black;">Follow Us At Instagram!</span>
                        <div>
                            <img src="../image/socialMedia/ig_clicked.png" alt="IG Logo">
                            <label for="bookSpare">@BookSpare</label>
                        </div>
                    </div>
                </div>
                <div>
                    <span class="notificationButton"><label for="notification"><i class='bx  bx-bell' ></i> </label></span>
                    <div class="accessibility notification">
                        <span style="color: black;">Notification</span>
                        <div class="notificationContentContainer">

                        <?php

// foreach ($getPost as $postRow) {

    $sqlGetNotificationHeader = "SELECT noti.*, post.postCode, book.bookTitle
                            FROM Notification noti
                            INNER JOIN post_review post USING (postCode)
                            INNER JOIN book_record book USING (bookID)
                            WHERE noti.readerID IS NULL AND noti.bookBorrowCode IS NULL
                            ORDER BY noti.notificationCode DESC";
    $resultGetNotificationHeader = $conn->query($sqlGetNotificationHeader);
    $notification = $resultGetNotificationHeader->fetch_all(MYSQLI_ASSOC);

    foreach ($notification as $notiRow) {
        
        $sqlGetCommentUserHeader = "SELECT * FROM Reader_User WHERE readerID = '{$notiRow['readerID']}'";
        $resultGetCommentUserHeader = $conn->query($sqlGetCommentUserHeader);
        $commentUser = $resultGetCommentUserHeader->fetch_assoc();
            
        // Comment Section
        // if ($commentUser['readerID'] != $readerID) {
        //     if ($notiRow['bookBorrowCode'] == null) {
        //         echo '    <div class="notificationContent">';  
        //         echo '        <label for="bookSpare">'.$commentUser['username'].'</label>';  
        //         echo '        <label for="bookSpare">Leave A New Comment!</label>';  
        //         echo '    </div>';
        //     } else {
        //         echo '    <div class="notificationContent">';  
        //         echo '        <label for="bookSpare">'.$commentUser['username'].'</label>';  
        //         echo '        <label for="bookSpare">Leave A New Comemnt & Rating!</label>';  
        //         echo '    </div>';                                         
        //     }
        // }

        if (empty($notiRow['readerID']) && empty($notiRow['bookBorrowCode'])) {
                echo '    <div class="notificationContent" data-postCode="'.$notiRow['postCode'].'">';  
                echo '        <label>Trending Book On ' . strtoupper(date("j F Y", strtotime($notiRow['notificationDate']))) . '</label>';
                echo '        <label for="bookSpare">\''.$notiRow['bookTitle'].'\' With High Avg Rate!</label>';  
                echo '    </div>';                  
        }
        
    }
// }

foreach ($commentDetailsHeader as $commentDetailsRow) {

    $sqlGetNotificationHeader = "SELECT noti.*,
                                        nestedComment.*
                            FROM Notification noti
                            INNER JOIN Nested_Comment_Rating nestedComment USING (nestedCommentCode)
                            WHERE nestedComment.commentCode = '{$commentDetailsRow['commentCode']}'";
    $resultGetNotificationHeader = $conn->query($sqlGetNotificationHeader);
    $notification = $resultGetNotificationHeader->fetch_all(MYSQLI_ASSOC);
    
    foreach ($notification as $notiRow) {
        
        $sqlGetCommentUserHeader = "SELECT * FROM Reader_User WHERE readerID = '{$notiRow['readerID']}'";
        $resultGetCommentUserHeader = $conn->query($sqlGetCommentUserHeader);
        $commentUser = $resultGetCommentUserHeader->fetch_assoc();
            
        // if ($commentUser['readerID'] != $readerID) {
        //     if ($notiRow['nestedCommentCode'] != null) {
        //         echo '    <div class="notificationContent"  data-postCode="'.$notiRow['postCode'].'">';  
        //         echo '        <label for="bookSpare">'.$commentUser['username'].'</label>';  
        //         echo '        <label for="bookSpare">Reply Your Message!</label>';  
        //         echo '    </div>';
        //     }
        // }
    }
}

foreach ($borrowNoti as $notiRow) {

    $sqlGetBorrowerHeader = "SELECT * FROM Reader_User WHERE readerID = '{$notiRow['borrowerID']}'";
    $resultGetBorrowerHeader = $conn->query($sqlGetBorrowerHeader);
    $borrowerHeader= $resultGetBorrowerHeader->fetch_assoc();

    if ($notiRow['readerID'] == $readerID) {
        if ($notiRow['statusBorrow'] === "PENDING") {
            echo '    <div class="notificationContent request">';  
            echo '        <label for="bookSpare">Borrow Request From '.$borrowerHeader['username'].'</label>';  
            echo '        <label for="bookSpare">Waiting For Your Approval!</label>';  
            echo '    </div>';
        }
    }

}

foreach ($borrowNoti2 as $notiRow) {

    $sqlGetBorrowerHeader = "SELECT * FROM Reader_User WHERE readerID = '{$notiRow['ownerID']}'";
    $resultGetBorrowerHeader = $conn->query($sqlGetBorrowerHeader);
    $borrowerHeader= $resultGetBorrowerHeader->fetch_assoc();

    if ($notiRow['readerID'] == $readerID) {
        if ($notiRow['statusBorrow'] === "APPROVED" && empty($notiRow['fullname'])) {
            echo '    <div class="notificationContent replyRequest">';  
            echo '        <label for="bookSpare">Book \''.$notiRow['bookTitle'].'\' Approved By '.$borrowerHeader['username'].'</label>';  
            echo '        <label for="bookSpare">Fill In The Your Personal Details Form!</label>';  
            echo '    </div>';
        }

        // Personal Details Answer By Borrower
        // if ($notiRow['statusBorrow'] === "APPROVED" && !empty($notiRow['fullname'])) {
        //     echo '    <div class="notificationContent replyDetailsForm">';  
        //     echo '        <label for="bookSpare">Details Form Answered By \''.$borrowerHeader['username'].'\'</label>';  
        //     echo '        <label for="bookSpare">Click To Read!</label>';  
        //     echo '    </div>';                                          
        // }
    }

}

?>
                            
                        </div>
                    </div>
                </div>
                <div>
                    <span class="profile">
                        <?php echo $user['username']; ?>
                        <a>
                        <?php 
                            
                            if ($user['avatar'] == null) {
                                echo $user['username'][0]; 
                            } else {
                                echo "<img src='../".$user['avatar']."' alt='Profile Image'>";
                            }
                        ?>
                        </a>
                    </span>
                </div>

            </nav>
            <box-icon name='menu' id="burgerIcon" size="10"></box-icon>
        </div>
        <aside>
            <div id="profile">
                <span class="profile">
                    <?php echo $user['username']; ?>
                    <a>
                        <?php echo $user['username'][0]; ?>
                    </a>
                </span>
            </div>
            <span id="mainButton"><label for="color">Main</label></span>
            <span id="mainButton"><label for="color" id="genreButton">Genre</label></span>
            <span id="mainButton"><label for="color" id="mypostButton">My Post</label></span>
            <span id="mainButton"><label for="color" id="InsightsButton">Insights</label></span>

            <div class="accessibility colorAccessibility">
                <div class="default option" data-color="defaultColor">Default</div>
                <div class="option" data-color="lightColor">Light</div>
                <div class="option" data-color="darkColor">Dark</div>
            </div>
            <span class="colorButton"><label for="color">Color</label></span>

            <div class="accessibility fontSizeAccessibility">
                <div class="option" data-setFontSize="smallFontSize">Small</div>
                <div class="default option" data-setFontSize="defaultFontSize">Default</div>
                <div class="option" data-setFontSize="largeFontSize">Large</div>
                <div class="option" data-setFontSize="veryLargeFontSize">Very Large</div>
            </div>
            <span class="fontSizeButton"><label for="fontSize">Font Size</label></span>

            <div class="accessibility support">
                <span style="color: black;">Follow Us At Instagram!</span>
                <div>
                    <img src="../image/socialMedia/ig_clicked.png" alt="IG Logo">
                    <label for="bookSpare">@BookSpare</label>
                </div>
            </div>
            <span class="supportButton"><label for="support">Support</label></span>
        </aside>
        <div id="secondHeader">
            <nav>
                <a href="../main.php"><label for="">Main</label></a>
                <a href="../genre.php"><label for="">Genre</label></a>
                <a href="../mainmyposts.php"><label for="">My Post</label></a>
                <a href="../borrowDetails.php"><label for="">Borrow Details</label></a>
                <a href="../barChart.php"><label for="">Insights</label></a>
            </nav>
            <form method="POST" action="search.php" class="headerForm">
                <box-icon name='search-alt'></box-icon>
                <input type="text" placeholder="Search by book name/ thread" name="search">
            </form>
            <nav>
                <a href="../logout.php"><label for="main">Logout</label></a>
            </nav>
        </div>
    </header>

    <script>
        $(document).ready(function() {
            $(".notificationContent").click(function() {
                let postCode = this.getAttribute("data-postCode");
                window.location.href = "../bookDetail.php?postCode=" + postCode;
            });

            $(".request").click(function() {
                window.location.href = "../borrowDetails.php?section=borrowRequest&sectionAside=receivedRequest";
            });

            $(".replyRequest").click(function() {
                window.location.href = "../borrowDetails.php?section=actionNeeded&sectionAside=toComplete";
            });
            
            // $(".replyDetailsForm").click(function() {
            //     window.location.href = "../borrowDetails.php?section=actionNeeded&sectionAside=formReceived";
            // });
            
        })
    </script>

</body>

</html>