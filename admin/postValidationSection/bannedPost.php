<?php

$sqlAllPost = "SELECT 
                post.*,
                reader.*,
                book.*
            FROM post_review post
            INNER JOIN reader_user reader USING (readerID)
            INNER JOIN book_record book USING (bookID)
            WHERE post.statusApprove = 'BANNED'
            ORDER BY post.datePosted DESC";
$runSQLAllPost = $conn->query($sqlAllPost);
$post = $runSQLAllPost->fetch_all(MYSQLI_ASSOC);

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


    echo '<div class="post postCode" data-postCode="'.$row['postCode'].'">';
    echo '    <div class="head">';
    echo '        <div class="postProfile">';
    
    $profileLink = "adminViewUsersProfile.php?readerID=" . $row['readerID'];

    if ($row['readerID'] != $readerID) {
        if (!empty($row['avatar'])) {
            echo '<a href="'.$profileLink.'"><img src="../'.$row['avatar'].'" alt="Profile Image"></a>';
        } else {
            echo '<a href="'.$profileLink.'">'.$row['username'][0].'</a>';
        }
    } else {
        if (!empty($row['avatar'])) {
            echo '<a href="'.$profileLink.'"><img src="../'.$row['avatar'].'" alt="Profile Image"></a>';
        } else {
            echo '<a href="'.$profileLink.'">'.$row['username'][0].'</a>';
        }                                
    }

    echo $row['username'];
    echo '        </div>';
    echo '    </div>';

    echo '    <div class="body">';
    echo '        <div class="right">';
    if ($row['frontCover_img'] != null) {
        echo '            <img src="../'.$row['frontCover_img'].'" alt="Book Cover">';
    }  else {
        echo '            <img src="../bookUploads/noImageUploaded.png" alt="Book Cover">';
    }
    echo '        </div>';
    echo '        <div class="right">';
    echo '          <h3>'.$row['bookTitle'].'</h3>';
    if ($averageRating != 0) {
        echo '<h4>Average Review: '.number_format($averageRating, 1).'</h4>';
    } else {
        echo '<h4>Average Review: No Rating</h4>';
    }
    echo '        </div>';
    echo '    </div>';

    echo '    <div class="bottom statusButton" style="justify-content: center;">';
    echo '        <a href="postValidationSection/approvalHandling.php?postCode='.$row['postCode'].'">Approve</a>';
    echo '    </div>';
    echo '</div>';
                            
}

?>