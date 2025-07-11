
<?php

if (!empty($comment)) {

    $a = 0;
    foreach ($comment as $rowComment) {

        $sqlGetNestedComment = "SELECT nestedComment.*,
                        comment.commentCode,
                        reader.*,
                        reader.readerID nestedCommentReaderID
                        FROM Nested_Comment_Rating nestedComment
                        INNER JOIN Comment_Rating comment USING (commentCode)
                        INNER JOIN Reader_User reader ON nestedComment.readerID = reader.readerID
                        WHERE nestedComment.commentCode = '{$rowComment['commentCode']}'";
        $resultsqlGetNestedComment = $conn->query($sqlGetNestedComment);
        $nestedComment = $resultsqlGetNestedComment->fetch_all(MYSQLI_ASSOC);
            
            echo '  <div class="commentContainer">';
            echo '      <div class="postProfile">';
            echo '          <div>';  
            echo '              <a href="">';  
            if ($rowComment['avatar'] != null) {
                echo '<img src="../'.$rowComment['avatar'].'" alt="Profile Image">';
            } else {
                echo $rowComment['username'][0];  
            }
            echo '</a>';   
            echo '              <label>'.$rowComment['username'].'</label>';   
            echo '          </div>'; 
            echo '          <div>';  
            echo '              <a href="postValidationSection/confirmationCommentBan.php?commentCode='.$rowComment['commentCode'].'&postCode='.$postCode.'">Ban Comment</a>';
            echo '          </div>';                            
            echo '      </div>';
            echo '      <div class="commentContent">';
            echo '          <label>';
            echo '              <b>Rating:</b> '.$rowComment['rating'].' / 10';
            echo '          </label>';
            echo '          <label>';
            echo '              <b>Comment:</b>'.$rowComment['comment'].'';
            echo '          </label>';
            echo '      </div>';

            foreach ($nestedComment as $rowNestedComment) {
                echo '  <div class="nestedCommentContainer">';
                echo '      <div class="postProfile">';
                echo '          <div>';  
                echo '              <a href="">';  
                if ($rowNestedComment['avatar'] != null) {
                    echo '<img src="../'.$rowNestedComment['avatar'].'" alt="Profile Image">';
                } else {
                    echo $rowNestedComment['username'][0];  
                }
                echo '</a>';   
                echo '              <label>'.$rowNestedComment['username'].'</label>';   
                echo '          </div>'; 
                echo '          <div>';  
                echo '              <a href="postValidationSection/confirmationCommentBan.php?nestedCommentCode='.$rowNestedComment['commentCode'].'&postCode='.$postCode.'">Ban Comment</a>';
                echo '          </div>';                            
                echo '      </div>';
                echo '      <div class="commentContent">';
                echo '          <label>';
                echo '              <b>Comment: </b>'.$rowNestedComment['comment'].'';
                echo '          </label>';
                echo '      </div>';
                echo '</div>';
            }

            echo ' </div>';
            $a++;

    }

    if ($a == 0) {
        echo '  <div class="commentContainer">';
        echo "No Comment & Rating Here!";
        echo '  </div>';
    }
} else {
    echo '  <div class="commentContainer">';
    echo "No Comment Here!";
    echo '  </div>';
}

?>