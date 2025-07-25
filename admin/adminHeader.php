<?php

    if (isset($readerID)) {
    $sqlGetPostDetailsHeader = "SELECT 
                            post.*,
                            reader.*,
                            book.*
                        FROM post_review post
                        INNER JOIN reader_user reader USING (readerID)
                        INNER JOIN book_record book USING (bookID)
                        WHERE post.readerID = '$readerID'
                        ORDER BY post.postCode DESC";
    $resultGetPostDetailsHeader = $conn->query($sqlGetPostDetailsHeader);
    $getPost = $resultGetPostDetailsHeader->fetch_all(MYSQLI_ASSOC);

    $sqlGetCommentDetailsHeader = "SELECT nestedComment.*,
                            comment.*
                            FROM Nested_Comment_Rating nestedComment
                            INNER JOIN Comment_Rating comment USING (commentCode)
                            WHERE comment.readerID = '$readerID'";
    $resultGetCommentDetailsHeader = $conn->query($sqlGetCommentDetailsHeader);
    $commentDetailsHeader = $resultGetCommentDetailsHeader->fetch_all(MYSQLI_ASSOC);
    }
?>
<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

<title></title>

</head>

<body>
    <header>
        <div id="firstHeader">
            <a href="adminMain.php" id="logo"><img src="../image/logoTitle.png" alt="logo" id="logoImage"></a>

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
                <!-- <div>
                    <span class="notificationButton"><label for="notification"><i class='bx  bx-bell' ></i> </label></span>
                    <div class="accessibility notification">
                        <span style="color: black;">Notification</span>
                        <div class="notificationContentContainer">

                            <?php

                                // foreach ($getPost as $postRow) {

                                //     $sqlGetNotificationHeader = "SELECT *
                                //                             FROM Notification noti
                                //                             INNER JOIN Post_Review post USING (postCode)
                                //                             INNER JOIN Comment_Rating comment USING (commentCode)
                                //                             WHERE noti.postCode = '{$postRow['postCode']}'";
                                //     $resultGetNotificationHeader = $conn->query($sqlGetNotificationHeader);
                                //     $notification = $resultGetNotificationHeader->fetch_all(MYSQLI_ASSOC);

                                //     foreach ($notification as $notiRow) {
                                        
                                //         $sqlGetCommentUserHeader = "SELECT * FROM Reader_User WHERE readerID = '{$notiRow['readerID']}'";
                                //         $resultGetCommentUserHeader = $conn->query($sqlGetCommentUserHeader);
                                //         $commentUser = $resultGetCommentUserHeader->fetch_assoc();
                                            
                                //         if ($commentUser['readerID'] != $readerID) {
                                //             if ($notiRow['bookBorrowCode'] == null) {
                                //                 echo '    <div class="notificationContent">';  
                                //                 echo '        <label for="bookSpare">'.$commentUser['username'].'</label>';  
                                //                 echo '        <label for="bookSpare">Leave A New Comment!</label>';  
                                //                 echo '    </div>';
                                //             } else {
                                //                 echo '    <div class="notificationContent">';  
                                //                 echo '        <label for="bookSpare">'.$commentUser['username'].'</label>';  
                                //                 echo '        <label for="bookSpare">Leave A New Comemnt & Rating!</label>';  
                                //                 echo '    </div>';                                         
                                //             }
                                //         }
                                        
                                //     }
                                // }

                                // foreach ($commentDetailsHeader as $commentDetailsRow) {

                                //     $sqlGetNotificationHeader = "SELECT noti.*,
                                //                                         nestedComment.*
                                //                             FROM Notification noti
                                //                             INNER JOIN Nested_Comment_Rating nestedComment USING (nestedCommentCode)
                                //                             WHERE nestedComment.commentCode = '{$commentDetailsRow['commentCode']}'";
                                //     $resultGetNotificationHeader = $conn->query($sqlGetNotificationHeader);
                                //     $notification = $resultGetNotificationHeader->fetch_all(MYSQLI_ASSOC);
                                    
                                //     foreach ($notification as $notiRow) {
                                        
                                //         $sqlGetCommentUserHeader = "SELECT * FROM Reader_User WHERE readerID = '{$notiRow['readerID']}'";
                                //         $resultGetCommentUserHeader = $conn->query($sqlGetCommentUserHeader);
                                //         $commentUser = $resultGetCommentUserHeader->fetch_assoc();
                                            
                                //         if ($commentUser['readerID'] != $readerID) {
                                //             if ($notiRow['nestedCommentCode'] != null) {
                                //                 echo '    <div class="notificationContent">';  
                                //                 echo '        <label for="bookSpare">'.$commentUser['username'].'</label>';  
                                //                 echo '        <label for="bookSpare">Reply Your Message!</label>';  
                                //                 echo '    </div>';
                                //             }
                                //         }
                                //     }
                                // }

                            ?>
                            
                        </div>
                    </div>
                </div> -->
                <div>
                    <span class="profile">
                        <?php echo $admin['adminUsername']; ?>
                        <a>
                        <?php 
                            
                            if ($admin['avatar'] == null) {
                                echo $admin['adminUsername'][0]; 
                            } else {
                                echo "<img src='../".$admin['avatar']."' alt='Profile Image'>";
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
                    <?php echo $admin['adminUsername']; ?>
                    <a>
                        <?php echo $admin['adminUsername'][0]; ?>
                    </a>
                </span>
            </div>

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
                    <img src="image/socialMedia/ig_clicked.png" alt="IG Logo">
                    <label for="bookSpare">@BookSpare</label>
                </div>
            </div>
            <span class="supportButton"><label for="support">Support</label></span>
        </aside>
        <div id="secondHeader">
            <nav>
                <a href="adminMain.php"><label for="" class="admin">Post&nbsp;Validation</label></a>
                <a href="adminInsights.php"><label for="" class="admin">Insights</label></a>
            </nav>
            <form method="POST" action="adminSearch.php" class="headerForm">
                <box-icon name='search-alt'></box-icon>
                <input type="text" placeholder="Search by book name/ thread" name="search">
            </form>
            <nav>
                <a href="adminLogout.php"><label for="main">Logout</label></a>
            </nav>
        </div>
    </header>

</body>

</html>