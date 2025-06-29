<?php

$sqlGetPostDetails = "SELECT 
                          post.*,
                          reader.*,
                          book.*,
                          borrow.readerID AS borrowerID
                      FROM post_review post
                      INNER JOIN reader_user reader USING (readerID)
                      INNER JOIN book_record book USING (bookID)
                      INNER JOIN book_borrowed borrow USING (postCode)
                      WHERE post.readerID = '$readerID'
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
                       borrow.*,
                       reader.*
                       FROM Book_Borrowed borrow
                       INNER JOIN Reader_User reader USING (readerID)
                       WHERE borrow.postCode = '{$row['postCode']}'
                       AND borrow.readerID = '{$row['borrowerID']}'";
    $resultBorrowDetails = $conn->query($sqlBorrowerDetails);
    $borrow = $resultBorrowDetails->fetch_assoc();

    if ($borrow['statusBorrow'] === "PENDING") {
        
        echo '<div data-readerID="'.$borrow['readerID'].'" class="post borrowerProfile received" data-postCode="'.$row['postCode'].'">';
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
    echo '        <div class="right">';
    if ($row['frontCover_img'] != null) {
        echo '            <img src="'.$row['frontCover_img'].'" alt="Book Cover">';
    }  else {
        echo '            <img src="bookUploads/noImageUploaded.png" alt="Book Cover">';
    }
    echo '        </div>';
    echo '        <div class="right">';
    echo '              <h1>Book Requested By</h1>';
    if (!empty($borrow['avatar'])) {
        echo '              <img src="'.$borrow['avatar'].'" alt="Borrower Profile Image">';
    } else {
        echo '              <a href="viewUsersProfile.php?postCode='.$row['postCode'].'&readerID='.$borrow['readerID'].'">'.$borrow['username'][0].'</a>';
    }
    echo '              <h1>'.$borrow['username'].'</h1>';
    echo '        </div>';
    echo '    </div>';
    echo '        <div class="bottom" style="border-bottom: 2px solid;">';
    echo '          <h3>'.$row['bookTitle'].'</h3>';
    if ($averageRating != 0) {
        echo '<h4>Average Review: '.number_format($averageRating, 1).'</h4>';
    } else {
        echo '<h4>Average Review: No Rating</h4>';
    }
    echo '        </div>';
    echo '    <div class="bottom statusButton">';
    echo '        <a href="backendLogic/bookApprovalHandling.php?postCode='.$row['postCode'].'&borrowerReaderID='.$borrow['readerID'].'">Approve</a>';
    echo '        <a href="backendLogic/bookRejectionHandling.php?postCode='.$row['postCode'].'&borrowerReaderID='.$borrow['readerID'].'">Reject</a>';
    echo '    </div>';
    echo '</div>';
    }
                            
}

?>