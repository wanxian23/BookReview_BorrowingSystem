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

        echo '        <tr>';  
        echo '            <td><a href="genreDetail.php?book='.$row['bookTitle'].'">'.$row['bookTitle'].'</a></td>';  
        if ($row['averageRating'] != 0) {
            echo '            <td>'.number_format($row['averageRating'], 1).'</td>'; 
        } else {
            echo '            <td>No Rating</td>'; 
        }
        echo '        </tr>';
        $x++;
    }
// }

for (; $x < 5; $x++) {
    echo '        <tr>';  
    echo '            <td>&nbsp;</td>';  
    echo '            <td>&nbsp;</td>';  
    echo '        </tr>';     
}

echo '    </tbody>'; 
echo '</table>';  

// echo '<div class="pagination">';  
// echo '    <button>';  
// echo '        &lt;';  
// echo '    </button>';  
// echo '    <span>1</span>';  
// echo '    <button>&gt;</button>';  
// echo '</div>';

?>