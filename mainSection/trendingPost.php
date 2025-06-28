<?php

foreach ($postHighAvg as $row) {

    $sqlGetComment = "SELECT
                        comment.*,
                        post.*,
                        reader.*
                    FROM Comment_Rating comment
                    INNER JOIN Post_Review post ON comment.postCode = post.postCode
                    INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
                    WHERE comment.postCode = '{$row['postCode']}'";
    $resultGetComemnt = $conn->query($sqlGetComment);
    $comment = $resultGetComemnt->fetch_all(MYSQLI_ASSOC);

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
    echo '    </div>';

    echo '    <div class="bottom">';
    // echo '        <div class="left">';
    // echo '        </div>';
    echo '          <h3>'.$row['bookTitle'].'</h3>';
    if ($averageRating != 0) {
        echo '<h4>Average Review: '.number_format($averageRating, 1).'</h4>';
    } else {
        echo '<h4>Average Review: No Rating</h4>';
    }
    echo '    </div>';
    echo '</div>';
}

?>