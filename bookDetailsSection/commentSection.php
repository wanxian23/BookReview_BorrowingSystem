
<?php

if (!empty($comment)) {

    foreach ($comment as $rowComment) {
        echo '  <div class="commentContainer">';
        echo '      <div class="postProfile">';
        echo '          <a href="">';  
        if ($rowComment['avatar'] != null) {
            echo '<img src="'.$rowComment['avatar'].'" alt="Profile Image">';
        } else {
            echo $rowComment['username'][0];  
        }
        echo '</a>';  
        echo '          <label>'.$rowComment['username'].'</label>';                             
        echo '      </div>';
        echo '      <div class="commentContent">';
        echo '          <label>';
        echo '              <b>Comment:</b> '.$rowComment['comment'].'';
        echo '          </label>';
        echo '      </div>';
        echo '  </div>';
    }
} else {
    echo '  <div class="commentContainer">';
    echo "No Comment Here!";
    echo '  </div>';
}

?>