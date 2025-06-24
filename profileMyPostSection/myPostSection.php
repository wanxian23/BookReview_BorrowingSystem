<div class="review-card">

<?php

    foreach ($post as $row) {

        $sqlGetComment = "SELECT
            comment.*,
            post.*,
            reader.*,
            bookBorrow.*
        FROM Comment_Rating comment
        INNER JOIN Post_Review post ON comment.postCode = post.postCode
        INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
        INNER JOIN book_borrowed bookBorrow ON comment.bookBorrowCode = bookBorrow.bookBorrowCode
        WHERE comment.postCode = '{$row['postCode']}'";
        $resultGetComemnt = $conn->query($sqlGetComment);
        $comment = $resultGetComemnt->fetch_all(MYSQLI_ASSOC);

        $averageRating = 0;
        if (!empty($comment)) {

                $i = 0;
                foreach($comment as $commentData) {

                    if ($commentData['bookBorrowCode'] != null) {
                        $averageRating += $commentData['ratingFeedback'];
                        $i++;
                    }

                }
                
                if ($i != 0) {
                    $averageRating = $averageRating / $i;
                }

        }

        if ($row['frontCover_img'] != null) {
            echo '<div class="post">';
            echo '    <div class="head">';
            echo '        <div class="postProfile">';
            if ($row['avatar'] != null) {
                echo '            <a href=""><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
            } else {
                echo '            <a href="">A</a>';                               
            }
            echo $row['username'];
            echo '        </div>';
            echo '    </div>';
            echo '    <div class="body">';
            echo '        <div class="left">';
            echo '            <div class="review">';
            echo '                <h2>Book Title: '.$row['bookTitle']. '</h2>';
            echo '                <h3><label for="">Review: '.$row['ownerRating'].'/10</label><label for="">Genre: '.$row['genre'].'</label></h3>';
            echo '            </div>';
            echo '            <div class="description">';
            echo '                <p>';
            echo substr($row['ownerOpinion'], 0, 310);
            echo '                    <a href="../profilemypostBookDetails.php?postCode='.$row['postCode'].'">... Read More</a>';
            echo '                </p>';
            echo '            </div>';
            echo '        </div>';
            echo '        <div class="right">';
            echo '            <img src="'.$row['frontCover_img'].'" alt="Book Cover">';
            echo '        </div>';
            echo '    </div>';
            echo '    <div class="bottom">';
            echo '        <div class="left">';
            echo '        </div>';
            if ($averageRating != 0) {
                echo '<h3>Average Review: '.number_format($averageRating, 1).'</h3>';
            } else {
                echo '<h3>Average Review: No Rating</h3>';
            }
            echo '    </div>';
            echo '</div>';
        } else {

            echo '<div class="post">';
            echo '    <div class="head">';
            echo '        <div class="postProfile">';
            if ($row['avatar'] != null) {
                echo '            <a href=""><img src="'.$row['avatar'].'" alt="Profile Image"></a>';
            } else {
                echo '            <a href="">A</a>';                               
            }
            echo $row['username'];
            echo '        </div>';
            echo '    </div>';
            echo '    <div class="body">';
            echo '        <div class="left">';
            echo '            <div class="review">';
            echo '                <h2>Book Title: '.$row['bookTitle']. '</h2>';
            echo '                <h3><label for="">Review: '.$row['ownerRating'].'/10</label><label for="">Genre: '.$row['genre'].'</label></h3>';
            echo '            </div>';
            echo '            <div class="description">';
            echo '                <p>';
            echo substr($row['ownerOpinion'], 0, 310);
            echo '                    <a href="bookDetail.php?postCode='.$row['postCode'].'">... Read More</a>';
            echo '                </p>';
            echo '            </div>';
            echo '        </div>';
            echo '        <div class="right">';
            echo '            <img src="bookUploads/noImageUploaded.png" alt="Book Cover">';
            echo '        </div>';
            echo '    </div>';
            echo '    <div class="bottom">';
            echo '        <div class="left">';
            echo '        </div>';
            if ($averageRating != 0) {
                echo '<h3>Average Review: '.number_format($averageRating, 1).'</h3>';
            } else {
                echo '<h3>Average Review: No Rating</h3>';
            }
            echo '    </div>';
            echo '</div>';
        }
                                
    }

    ?>
</div>