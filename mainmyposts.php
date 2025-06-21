<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'OR email = '$username' OR phone = '$username'";
$runSQL = $conn->query($sql);

$user = $runSQL->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>

    <?php include("headDetails.html"); ?>
    <title>BookSpare - Search Results</title>

    <style>
    main {
        margin: 2% 0;
        padding: 20px;
        max-width: 1200px;
        margin: 2% auto;
    }

    .search-results-header {
    background: transparent;
    border-radius: 0;
    padding: 0 0 10px 0;
    margin-bottom: 10px;
    font-weight: bold;
    font-size: 16px;
    color: #333;
    margin-top: 10px;
}

.my-posts-header {
        padding: 15px 20px;
        display: flex;
        justify-content: center;
        align-items: center;
        position: sticky;
        min-height: 50px;
        position: relative;
        border-bottom: 2px solid black;
    }
    
.back-button {
        position: absolute;
        left: 20px;
        font-size: 16px;
        font-weight: bold;
        color: #333;
        display: flex;
        align-items: center;
        gap: 5px;
        cursor: pointer;
        text-decoration: none;
    }

    .my-posts-title {
        font-size: 24px;
        font-weight: bold;
        color: #333;
        text-align: center;
        flex-grow: 1;
        margin-right: 60px;
    }

    .my-posts-header::after {
        content: '';
        display: block;
        margin-top: 10px;
        margin-left: -20px;
        margin-right: -20px;
        padding: 0 20px;
    }


.result-post{
    border-bottom: 2px solid black;
}


    .results-container {
        background: white;
        border: 2px solid black;
        border-radius: 15px;
        padding: 20px;
        height: 700px;
        overflow-y: auto;
    }

    .results-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
        margin-top: 30px;
    }

    .review-card {
        border: 2px solid #333;
        border-radius: 15px;
        background: white;
        overflow: hidden;
        width: 100%;
        height: 350px;
        display: flex;
        flex-direction: column;
    }

    .review-header {
        background: #b19cd9;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .user-initial {
        width: 35px;
        height: 35px;
        background: #333;
        border-radius: 50%;
        color: white;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
    }

    .user-name {
        font-weight: bold;
        color: #333;
    }

    .review-content {
        display: flex;
        padding: 15px;
        gap: 15px;
        overflow-y: auto;
        flex: 1;
    }

    .review-left {
        flex: 1;
        overflow-y: auto;
    }

    .book-title {
        font-weight: bold;
        font-size: 16px;
        margin-bottom: 8px;
        color: #333;
    }

    .review-details {
        display: flex;
        justify-content: space-between;
        margin-bottom: 15px;
        font-size: 14px;
        color: #666;
    }

    .review-text {
        font-size: 14px;
        line-height: 1.4;
        margin-bottom: 10px;
        color: #333;
    }

    .read-more {
        color: #888;
        text-decoration: none;
        font-size: 14px;
    }
.book-image {
            width: 120px;
            height: 170px;
            object-fit: cover;
            border-radius: 5px;
            border: 1px solid #ddd;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #666;
            font-size: 12px;
            text-align: center;
        }

    .comment-section {
        background: #f8f8f8;
        padding: 15px;
        border-top: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .comment-input-container {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .comment-icon {
        width: 20px;
        height: 20px;
    }

    .comment-input {
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 20px;
        font-size: 14px;
        width: 200px;
    }

    .average-review {
        font-size: 14px;
        font-weight: bold;
        color: #333;
    }

    @media (max-width: 768px) {
        .results-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

</head>

<body>
    <?php include("header.php"); ?>

    <main>
        <div class="results-container">
            <div class="my-posts-header">
    <a href="#" class="back-button">
        <box-icon name='arrow-left'></box-icon> Back
    </a>
    <span class="my-posts-title">My Posts</span>
</div>
            <div class="results-grid">
                <div class="review-card">
                    <div class="review-header">
                        <div class="user-initial">H</div>
                        <div class="user-name">XXX</div>
                    </div>
                    <div class="review-content">
                        <div class="review-left">
                            <div class="book-title">Book Title: XXXX XXX</div>
                            <div class="review-details">
                                <span>Review: 7.5 / 10</span>
                                <span>Genre: Horror</span>
                            </div>
                            <div class="review-text">
                                In my opinion, I think xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx... 
                                <a href="#" class="read-more">Read More</a>
                            </div>
                        </div>
                        <div class="book-image">
                            Book Cover Image
                        </div>
                    </div>
                    <div class="comment-section">
                        <div class="comment-input-container">
                            <box-icon name='comment' size="20px"></box-icon>
                            <input type="text" class="comment-input" placeholder="Comment">
                        </div>
                        <span class="average-review">Average Review : 1.9</span>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-header">
                        <div class="user-initial">H</div>
                        <div class="user-name">XXX</div>
                    </div>
                    <div class="review-content">
                        <div class="review-left">
                            <div class="book-title">Book Title: XXXX XXX</div>
                            <div class="review-details">
                                <span>Review: 7.5 / 10</span>
                                <span>Genre: Horror</span>
                            </div>
                            <div class="review-text">
                                In my opinion, I think xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx... 
                                <a href="#" class="read-more">Read More</a>
                            </div>
                        </div>
                        <div class="book-image">
                            Book Cover Image
                        </div>
                    </div>
                    <div class="comment-section">
                        <div class="comment-input-container">
                            <box-icon name='comment' size="20px"></box-icon>
                            <input type="text" class="comment-input" placeholder="Comment">
                        </div>
                        <span class="average-review">Average Review : 1.9</span>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-header">
                        <div class="user-initial">J</div>
                        <div class="user-name">XXX</div>
                    </div>
                    <div class="review-content">
                        <div class="review-left">
                            <div class="book-title">Book Title: XXXX XXX</div>
                            <div class="review-details">
                                <span>Review: 8.0 / 10</span>
                                <span>Genre: Mystery</span>
                            </div>
                            <div class="review-text">
                                In my opinion, I think xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx... 
                                <a href="#" class="read-more">Read More</a>
                            </div>
                        </div>
                        <div class="book-image">
                            Book Cover Image
                        </div>
                    </div>
                    <div class="comment-section">
                        <div class="comment-input-container">
                            <box-icon name='comment' size="20px"></box-icon>
                            <input type="text" class="comment-input" placeholder="Comment">
                        </div>
                        <span class="average-review">Average Review : 2.4</span>
                    </div>
                </div>

                <div class="review-card">
                    <div class="review-header">
                        <div class="user-initial">K</div>
                        <div class="user-name">XXX</div>
                    </div>
                    <div class="review-content">
                        <div class="review-left">
                            <div class="book-title">Book Title: XXXX XXX</div>
                            <div class="review-details">
                                <span>Review: 6.5 / 10</span>
                                <span>Genre: Thriller</span>
                            </div>
                            <div class="review-text">
                                In my opinion, I think xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx... 
                                <a href="#" class="read-more">Read More</a>
                            </div>
                        </div>
                        <div class="book-image">
                            Book Cover Image
                        </div>
                    </div>
                    <div class="comment-section">
                        <div class="comment-input-container">
                            <box-icon name='comment' size="20px"></box-icon>
                            <input type="text" class="comment-input" placeholder="Comment">
                        </div>
                        <span class="average-review">Average Review : 3.1</span>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </main>

    <?php include("footer.html"); ?>

    <script>
        // Add some interactivity
        document.querySelectorAll('.read-more').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                alert('Read more functionality would expand the review text');
            });
        });

        document.querySelectorAll('.comment-input').forEach(input => {
            input.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    alert('Comment functionality would post the comment');
                    this.value = '';
                }
            });
        });
    </script>
</body>

</html>