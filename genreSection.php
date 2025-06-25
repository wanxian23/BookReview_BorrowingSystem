<?php

echo '<table class="genre-table">';  
echo '    <thead>';  
echo '        <tr>';  
echo '            <th>TITLE</th>';  
echo '            <th>REVIEWS</th>';  
echo '        </tr>';  
echo '    </thead>'; 
echo '    <tbody>'; 

$x = 0;
foreach ($post as $row) { 

    if (!empty($row)) {
        $sqlGetComment = "SELECT
            comment.*,
            post.*,
            reader.*,
            bookBorrow.*
        FROM Comment_Rating comment
        INNER JOIN Post_Review post ON comment.postCode = post.postCode
        INNER JOIN Reader_User reader ON comment.readerID = reader.readerID
        INNER JOIN book_borrowed bookBorrow ON comment.bookBorrowCode = bookBorrow.bookBorrowCode
        WHERE post.genre LIKE '{$row['genre']}'";
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

        echo '        <tr>';  
        echo '            <td><a href="genreDetail.php?book='.$row['bookTitle'].'">'.$row['bookTitle'].'</a></td>';  
        if ($averageRating != 0) {
            echo '            <td>'.number_format($averageRating, 1).'</td>'; 
        } else {
            echo '            <td>No Rating</td>'; 
        }
        echo '        </tr>'; 
    }

    $x++;
}

for (; $x < 5; $x++) {
    echo '        <tr>';  
    echo '            <td>&nbsp;</td>';  
    echo '            <td>&nbsp;</td>';  
    echo '        </tr>';     
}

echo '    </tbody>'; 
echo '</table>';  

echo '<div class="pagination">';  
echo '    <button>';  
echo '        &lt;';  
echo '    </button>';  
echo '    <span>1</span>';  
echo '    <button>&gt;</button>';  
echo '</div>';

?>