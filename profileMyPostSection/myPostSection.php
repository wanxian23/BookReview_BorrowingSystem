

<?php

    foreach ($post as $row) {

        $sqlGetComment = "SELECT rating as averageRating
        FROM Comment_Rating
        WHERE postCode = '{$row['postCode']}'";
        $resultGetComemnt = $conn->query($sqlGetComment);
        $comment = $resultGetComemnt->fetch_all(MYSQLI_ASSOC);

        $averageRating = 0;
        if (!empty($comment)) {

                $i = 0;
                foreach($comment as $commentData) {
                    $averageRating += $commentData['averageRating'];
                    $i++;
                }
                
                if ($i != 0) {
                    $averageRating = $averageRating / $i;
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
        // echo '        <div class="left">';
        // echo '            <div class="review">';
        // echo '                <h2>Book Title: '.$row['bookTitle'].'</h2>';
        // echo '                <h3><label for="">Review: '.$row['ownerRating'].'/10</label><label for="">Genre: '.$row['genre'].'</label></h3>';
        // echo '            </div>';
        // echo '            <div class="description">';
        // echo '                <p>';
        // echo substr($row['ownerOpinion'], 0, 180);
        // echo '                    <a href="bookDetail.php?postCode='.$row['postCode'].'">... Read More</a>';
        // echo '                </p>';
        // echo '            </div>';
        // echo '        </div>';
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
