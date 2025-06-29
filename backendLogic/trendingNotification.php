<?php 

require("../database/database.php");


$sqlGetPostHighAvg = "SELECT 
                        post.*, 
                        reader.*, 
                        book.*, 
                        AVG(comment.rating) AS averageRating
                    FROM post_review post
                    INNER JOIN reader_user reader USING (readerID)
                    INNER JOIN book_record book USING (bookID)
                    LEFT JOIN comment_rating comment USING (postCode)
                    WHERE post.statusApprove != 'BANNED' AND
                    post.statusApprove != 'SUSPICIOUS'
                    GROUP BY post.postCode
                    ORDER BY averageRating DESC, post.datePosted DESC LIMIT 1";
$resultGetPostighAvg = $conn->query($sqlGetPostHighAvg);
$postHighAvg = $resultGetPostighAvg->fetch_assoc();

date_default_timezone_set("Asia/Kuala_Lumpur");
$todayDateTime = date("Y-m-d H:i:s");

$sqlTrending = "INSERT INTO notification (postCode, status, notificationDate) VALUES ('{$postHighAvg['postCode']}','UNREAD','$todayDateTime')";
$runSQL = $conn->query($sqlTrending);

?>