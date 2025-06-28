<?php

$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      INNER JOIN book_borrowed borrow USING (postCode)
                      WHERE post.readerID = '$readerID'
                      AND borrow.statusBorrow = 'APPROVED'
                      AND borrow.fullname != ''
                      ORDER BY borrow.dateRequestSent DESC";
$resultGetPostDetails = $conn->query($sqlGetPostDetails);
$post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);

foreach ($post as $row) {

    $sqlAvgComment = "SELECT rating as averageRating
        FROM Comment_Rating
        WHERE postCode = '{$row['postCode']}'";
    $resultGetAvgComemnt = $conn->query($sqlAvgComment);
    $commentAvg = $resultGetAvgComemnt->fetch_all(MYSQLI_ASSOC);

    $averageRating = 0;
    if (!empty($commentAvg)) {

        $x = 0;
        foreach($commentAvg as $commentData) {

            $averageRating += $commentData['averageRating'];
            $x++;

        }

        if ($x != 0) {
            $averageRating = $averageRating / $x;
        }

    }


    $sqlBorrowerDetails = "SELECT 
                          reader.*,
                          borrow.statusBorrow
                      FROM book_borrowed borrow
                      INNER JOIN reader_user reader USING (readerID)
                      WHERE borrow.postCode = '{$row['postCode']}'
                      AND borrow.statusBorrow = 'APPROVED'
                      AND borrow.fullname != ''";
    $resultGetBorrowerDetails = $conn->query($sqlBorrowerDetails);
    $borrower = $resultGetBorrowerDetails->fetch_assoc();


    echo '<div id="viewReplyForm" class="post postCode" data-readerID="'.$row['readerID'].'" data-postCode="'.$row['postCode'].'"  style="height: 220px; width: 350px;">';
    echo '    <div class="head">';
    echo '        <div class="postProfile">';
    
    $profileLink = "viewUsersProfile.php?readerID=" . $row['readerID'];

    if ($row['readerID'] != $readerID) {
        if (!empty($row['avatar'])) {
            echo '<a href="'.$profileLink.'"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
        } else {
            echo '<a href="'.$profileLink.'">'.$row['username'][0].'</a>';
        }
    } else {
        if (!empty($row['avatar'])) {
            echo '<a href="profilemyposts.php"><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
        } else {
            echo '<a href="profilemyposts.php">'.$row['username'][0].'</a>';
        }                                
    }

    echo $row['username'];
    echo '        </div>';
    echo '    </div>';

    echo '    <div class="body">';
    echo '    </div>';

    echo '    <div class="bottom" style="border-bottom: 2px solid;">';
    // echo '        <div class="left">';
    // echo '        </div>';
    echo '          <h3>'.$row['bookTitle'].'</h3>';
    if ($averageRating != 0) {
        echo '<h4>Average Review: '.number_format($averageRating, 1).'</h4>';
    } else {
        echo '<h4>Average Review: No Rating</h4>';
    }
    echo '    </div>';
    echo '    <div class="bottom">';
    echo '      <h3 style="color: red;">\''.$borrower['username'].'\' Has Answer The Borrow Form!</h3>';
    echo '      <h3 style="color: red;">Click To View!</h3>';
    echo '    </div>';
    echo '</div>';
                            
}

?>