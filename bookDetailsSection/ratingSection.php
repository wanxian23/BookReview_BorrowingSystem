
<?php

if (!empty($comment)) {

    $noRating = false;

    foreach ($comment as $rowComment) {
        
        if ($rowComment['bookBorrowCode'] != null) {
            echo '  <div class="commentContainer">';
            echo '      <div class="postProfile">';
            echo '          <a href="">';  
            if ($rowComment['avatar'] != null) {
                echo '<img src="'.$rowComment['avatar'].'" alt="Profile Image">';
            } else {
                echo 'A';  
            }
            echo '</a>';   
            echo '          <label>xxxxxx</label>';                             
            echo '      </div>';
            echo '      <div class="commentContent">';
            echo '          <label>';
            echo '              <b>Rating:</b> XX / 10';
            echo '          </label>';
            echo '          <label>';
            echo '              <b>Comment:</b> xxxxxxxxxxxxxxxxxxxxxx';
            echo '          </label>';
            echo '      </label>';
            echo '  </div>';
            echo ' </div>';

            $noRating = false;
        } else {
            $noRating = true;
        }

    }

    if ($noRating) {
        echo '  <div class="commentContainer">';
        echo "No Comment & Rating Here!";
        echo '  </div>';
    }
} else {
    echo '  <div class="commentContainer">';
    echo "No Comment & Rating Here!";
    echo '  </div>';
}

?>