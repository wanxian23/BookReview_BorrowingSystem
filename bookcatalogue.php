<?php

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
    exit();
}

require("database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];
$readerID = $_SESSION['readerID'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();

// Assuming you'll pass a book ID via GET request, e.g., book_detail.php?id=123
$bookId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$bookDetails = null;
if ($bookId > 0) {
    // Example query to fetch book details
    // You'll need to replace 'YourBooksTable' and its columns with your actual table and column names
    $stmt = $conn->prepare("SELECT book_title, author, genre, available_for_borrow, review_score, front_cover_path, back_cover_path, synopsis FROM YourBooksTable WHERE book_id = ?");
    $stmt->bind_param("i", $bookId);
    $stmt->execute();
    $result = $stmt->get_result();
    $bookDetails = $result->fetch_assoc();
    $stmt->close();
}

// Example comments data (replace with actual database fetch later)
$comments = [
    ['user' => 'XXX', 'comment' => 'In my opinion, I think xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx.'],
    ['user' => 'XXX2', 'comment' => 'In my opinion, I think yyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy.'],
];


?>
<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookSpare - Book Detail</title>
    <style>
        :root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black; /* Used for borders that should change with theme */

            --buttonColor: #a9a1ee;
            --buttonFontColor: black;
            --buttonHoverColor: #d8d5ec;

            --postHeaderBgColor: rgb(220, 196, 238);
            --postBgColor: white;

            --commentButtonColor: rgb(161, 178, 238);
            --commentButtonFontColor: black;
            --commentButtonFontColorActive: black;
            --commentButtonHoverColor: rgb(205, 212, 234);

            --linkColor: blue;

            /* Specific colors from the original book_detail.php HTML which are not theme-controlled initially */
            --headerBgColorDefault: #ffe96b;
            --tabBarBgColorDefault: #d3dbe3;
            --bodyBgColorDefault: #fff8dc;
            --commentsBoxBgDefault: #f9f9f9;
            --footerBgColorDefault: #e5e5e5;
            --avatarBgColorDefault: #e2c3e9;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --buttonColor: black; /* Changed to black for light theme */
            --buttonFontColor: white;
            --buttonHoverColor: #646368;

            --postHeaderBgColor: white;
            --postBgColor: white;

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: rgb(134, 155, 195);
            --commentButtonHoverColor: rgb(91, 87, 87);

            --linkColor: blue;

            /* Light theme still uses default specific colors for now as per previous instruction */
            --headerBgColor: var(--headerBgColorDefault);
            --tabBarBgColor: var(--tabBarBgColorDefault);
            --bodyBgColor: var(--bodyBgColorDefault);
            --commentsBoxBg: var(--commentsBoxBgDefault);
            --footerBgColor: var(--footerBgColorDefault);
            --avatarBgColor: var(--avatarBgColorDefault);
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(34, 34, 34);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
            --contentBgColor: rgb(53, 53, 53);
            --borderColor: white;

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;
            
            --postHeaderBgColor: rgb(1, 1, 1);
            --postBgColor: rgb(45, 45, 45);

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: white;
            --commentButtonHoverColor: rgb(91, 87, 87);

            --linkColor: rgb(119, 167, 190);

            /* Dark theme specific color overrides for header, etc. */
            --headerBgColor: #444;
            --tabBarBgColor: #555;
            --bodyBgColor: #222;
            --commentsBoxBg: #333;
            --footerBgColor: #3a3a3a;
            --avatarBgColor: #666;
        }:root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --buttonColor: #a9a1ee;
            --buttonFontColor: black;
            --buttonHoverColor: #d8d5ec;

            --postHeaderBgColor: rgb(220, 196, 238);
            --postBgColor: white;

            --commentButtonColor: rgb(161, 178, 238);
            --commentButtonFontColor: black;
            --commentButtonFontColorActive: black;
            --commentButtonHoverColor: rgb(205, 212, 234);

            --linkColor: blue;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #646368;

            --postHeaderBgColor: white;
            --postBgColor: white;

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: rgb(134, 155, 195);
            --commentButtonHoverColor: rgb(91, 87, 87);

            --linkColor: blue;
        }

        [data-themeColor="darkColor"] {
            --containerBgColor: rgb(34, 34, 34);
            --containerColor: rgb(213, 213, 213);
            --containerBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
            --contentBgColor: rgb(53, 53, 53);
            --borderColor: white;

            --buttonColor: black;
            --buttonFontColor: white;
            --buttonHoverColor: #8d8c8c;

            
            --postHeaderBgColor: rgb(1, 1, 1);
            --postBgColor: rgb(45, 45, 45);

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: white;
            --commentButtonHoverColor: rgb(91, 87, 87);

            --linkColor: rgb(119, 167, 190);
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: var(--bodyBgColor, var(--bodyBgColorDefault)); /* Use themed or default */
            color: var(--containerColor);
        }

        header {
            background-color: var(--headerBgColor, var(--headerBgColorDefault)); /* Use themed or default */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 30px;
            color: var(--containerColor);
        }

        .logo {
            font-weight: bold;
            font-size: 1.3em;
        }

        .menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .tab-bar {
            background-color: var(--tabBarBgColor, var(--tabBarBgColorDefault)); /* Use themed or default */
            padding: 10px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: var(--containerColor);
        }

        .tabs span {
            margin-right: 20px;
            font-weight: bold;
            border-bottom: 2px solid var(--borderColor);
        }

        .tabs span[style*="color: gray"] {
            border-bottom: none;
            font-weight: normal;
            color: gray;
        }

        .search input {
            padding: 5px 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            background-color: var(--contentBgColor);
            color: var(--containerColor);
        }
        .search input::placeholder {
            color: var(--containerColor); /* Adjust placeholder color for readability */
            opacity: 0.7;
        }


        main {
            max-width: 900px;
            margin: 30px auto;
            background: var(--contentBgColor);
            border: 2px solid var(--borderColor); /* Use borderColor for consistency */
            border-radius: 15px;
            padding: 20px;
            color: var(--containerColor);
        }

        .back-button {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: bold;
            margin-bottom: 20px;
            color: var(--linkColor); /* Use linkColor for navigation buttons */
            cursor: pointer; /* Indicate it's clickable */
        }

        .book-details {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border: 1px solid var(--borderColor); /* Use borderColor for consistency */
            padding: 20px;
            border-radius: 10px;
            background-color: var(--containerBgColor);
        }

        .book-details img {
            width: 120px;
            height: auto;
            border: 1px solid var(--borderColor);
        }

        .book-info {
            flex: 1;
            padding-left: 20px;
        }

        .rating {
            font-size: 1.6em;
            font-weight: bold;
        }

        .comments-section {
            margin-top: 30px;
        }

        .comments-box {
            max-height: 250px;
            overflow-y: auto;
            border: 1px solid var(--borderColor); /* Use borderColor for consistency */
            padding: 20px;
            border-radius: 10px;
            background-color: var(--commentsBoxBg, var(--commentsBoxBgDefault)); /* Use themed or default */
        }

        .comment {
            margin-bottom: 20px;
        }

        .comment .avatar {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            height: 40px;
            width: 40px;
            border-radius: 50%;
            background-color: var(--avatarBgColor, var(--avatarBgColorDefault)); /* Use themed or default */
            font-weight: bold;
            color: black; /* Keep black as it's a specific instruction for avatar text */
        }

        .footer {
            background-color: var(--footerBgColor, var(--footerBgColorDefault)); /* Use themed or default */
            padding: 30px;
            text-align: center;
            margin-top: 50px;
            color: var(--containerColor);
        }

        .footer p {
            margin: 10px 0;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            header, .tab-bar {
                padding: 10px 15px;
                flex-wrap: wrap;
            }

            .menu {
                gap: 10px;
                margin-top: 10px;
                justify-content: center;
                width: 100%;
            }

            .tab-bar .tabs, .tab-bar .search {
                margin-top: 10px;
                width: 100%;
                justify-content: center;
                display: flex;
            }

            .book-details {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .book-details img {
                margin-bottom: 15px;
            }

            .book-info {
                padding-left: 0;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <header>
        <div class="logo">📖 BookSpare</div>
        <div class="menu">
            <div>Colour ▼</div>
            <div>Font Size ▼</div>
            <div>Support ▼</div>
            <div>🔔</div>
            <div><?php echo htmlspecialchars($user['username'] ?? 'User'); ?></div>
            <div class="avatar" style="background-color: var(--avatarBgColor, var(--avatarBgColorDefault));">
                <?php echo htmlspecialchars(substr($user['username'] ?? 'U', 0, 1)); ?>
            </div>
        </div>
    </header>
    <div class="tab-bar">
        <div class="tabs">
            <span>Main</span>
            <span style="color: gray; font-weight: normal; border: none;">Genre</span>
        </div>
        <div class="search">
            🔍 <input type="text" placeholder="Search">
        </div>
        <div>Logout</div>
    </div>
    <main>
        <div class="back-button">⬅ Back</div>
        <h2>Detail of the Book</h2>
        <div class="book-details">
            <?php if ($bookDetails && $bookDetails['front_cover_path']): ?>
                <img src="<?php echo htmlspecialchars($bookDetails['front_cover_path']); ?>" alt="Book cover">
            <?php else: ?>
                <img src="https://via.placeholder.com/120x180?text=No+Cover" alt="No Book cover available">
            <?php endif; ?>
            
            <div class="book-info">
                <div><strong><?php echo htmlspecialchars($bookDetails['book_title'] ?? 'N/A'); ?></strong></div>
                <div>Author: <?php echo htmlspecialchars($bookDetails['author'] ?? 'N/A'); ?></div>
                <div>Genre: <?php echo htmlspecialchars($bookDetails['genre'] ?? 'N/A'); ?></div>
                <div>Available for borrowing?: <?php echo ($bookDetails['available_for_borrow'] ?? 0) ? 'Yes' : 'No'; ?></div>
            </div>
            <div class="rating"><?php echo htmlspecialchars(number_format($bookDetails['review_score'] ?? 0, 1)); ?>/10</div>
        </div>
        
        <?php if ($bookDetails && $bookDetails['synopsis']): ?>
        <div class="comments-section" style="margin-top: 20px;">
            <h3>Synopsis:</h3>
            <div class="comments-box">
                <p><?php echo nl2br(htmlspecialchars($bookDetails['synopsis'])); ?></p>
            </div>
        </div>
        <?php endif; ?>

        <div class="comments-section">
            <h3>Comments:</h3>
            <div class="comments-box">
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <div><span class="avatar"><?php echo htmlspecialchars(substr($comment['user'], 0, 1)); ?></span> <strong><?php echo htmlspecialchars($comment['user']); ?></strong></div>
                        <div><?php echo htmlspecialchars($comment['comment']); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>
    <div class="footer">
        <p>Follow Us At</p>
        <p>📷</p>
        <p>Copyright © 2025 BookSpare. All right reserved</p>
    </div>
</body>
</html>
<?php
if (isset($conn) && $conn) {
    $conn->close();
}
?>