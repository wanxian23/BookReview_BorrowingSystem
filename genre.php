<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
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

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <?php include("headDetails.html"); ?>
    <title>Genre</title>

    <style>
        :root {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --buttonColor: white;
            --buttonFontColor: black;
            --buttonHoverColor: #d4d4d4;

            --tableFontColor: black;
            --tableBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --thBgColor: #acaedeec;
            --tdBgColor: white;

            --commentButtonColor: rgb(161, 178, 238);
            --commentButtonFontColor: black;
            --commentButtonFontColorActive: rgb(201, 206, 228);
            --commentButtonHoverColor: rgb(205, 212, 234);

            --linkColor: blue;
        }

        [data-themeColor="lightColor"] {
            --containerBgColor: #f5f5f5;
            --containerColor: black;
            --containerBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --contentBgColor: white;
            --borderColor: black;

            --buttonColor: rgb(237, 237, 237);
            --buttonFontColor: rgb(0, 0, 0);
            --buttonHoverColor: #c3c3c3;

            --tableFontColor: black;
            --tableBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --thBgColor: rgb(238, 238, 238);
            --tdBgColor: white;

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: rgb(191, 191, 191);
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
            --buttonFontColor: rgb(221, 221, 221);
            --buttonHoverColor: #414141;

            --tableFontColor: rgb(221, 221, 221);
            --tableBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
            --thBgColor: black;
            --tdBgColor: rgb(53, 53, 53);

            --commentButtonColor: rgb(23, 24, 25);
            --commentButtonFontColor: white;
            --commentButtonFontColorActive: rgb(95, 92, 92);
            --commentButtonHoverColor: rgb(97, 96, 96);

            --linkColor: rgb(119, 167, 190);
        }

        main {
            margin: 50px auto;
            max-width: 90%;
            text-align: center;
        }

        .genre-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .genre-buttons button {
            flex: 18%;
            border: 2px solid var(--borderColor);
            border-radius: 20px;
            padding: 10px 20px;
            color: var(--buttonFontColor);
            background-color: var(--buttonColor);
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .genre-buttons button.active {
            background-color: var(--commentButtonFontColorActive);
            border: 2px solid var(--borderColor);
        }

        .genre-buttons button:hover {
            background-color: var(--buttonHoverColor);
        }

        /*.search-bar {
            margin-bottom: 20px;
        }

        .search-bar input {
            width: 40%;
            padding: 10px;
            border-radius: 50px;
            border: 1px solid #aaa;
        }*/

        .genre-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            box-shadow: var(--tableBoxShadow);
        }

        .genre-table th,
        .genre-table td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
            width: 50%;
            color: var(--tableFontColor);
        }

        .genre-table td {
            background-color: var(--tdBgColor);
        }

        .genre-table td a {
            text-decoration: none;
            color: var(--linkColor);
            transition: 0.2s;
        }

        .genre-table td a:hover {
            color: var(--borderColor);
        }

        .genre-table th {
            background-color: var(--thBgColor);
            font-weight: bold;
            border: 1px solid;
        }


        .pagination {
            text-align: right;
            padding-right: 10px;
        }

        .pagination button {
            border: none;
            color: var(--buttonFontColor);
            background-color: var(--buttonColor);
            padding: 5px 10px;
            margin: 0 2px;
            border-radius: 5px;
            cursor: pointer;
        }

        .pagination button:hover {
            background-color: var(--buttonHoverColor);
        }

        @media (max-width: 650px) {
            .genre-buttons button {
                flex: 45%;
            }
        }
    </style>

</head>

<body>
    
        <?php include("header.php"); ?>

    <main>
        <form class="genre-buttons" action="<?php echo htmlspecialchars("genre.php"); ?>" method="GET">
            
        <?php

            $romanceActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Romance') ? 'active' : '';
            $horrorActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Horror') ? 'active' : '';
            $fantasyActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Fantasy') ? 'active' : '';
            $scifiActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Scifi') ? 'active' : '';
            $crimeActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Crime') ? 'active' : '';
            $comedyActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Comedy') ? 'active' : '';
            $mysteryActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Mystery') ? 'active' : '';
            $actionActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Action') ? 'active' : '';
            $dramaActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Drama') ? 'active' : '';
            $educationalActive = (isset($_GET['genreSection']) && $_GET['genreSection'] === 'Educational') ? 'active' : '';

        ?>
            <button type="submit" value="Romance" name="genreSection" class="<?php echo $romanceActive ?>">ROMANCE</button>
            <button type="submit" value="Horror" name="genreSection" class="<?php echo $horrorActive ?>">HORROR</button>
            <button type="submit" value="Fantasy" name="genreSection" class="<?php echo $fantasyActive ?>">FANTASY</button>
            <button type="submit" value="Scifi" name="genreSection" class="<?php echo $scifiActive ?>">SCI-FI</button>
            <button type="submit" value="Crime" name="genreSection" class="<?php echo $crimeActive ?>">CRIME</button>
            <button type="submit" value="Comedy" name="genreSection" class="<?php echo $comedyActive ?>">COMEDY</button>
            <button type="submit" value="Mystery" name="genreSection" class="<?php echo $mysteryActive ?>">MYSTERY</button>
            <button type="submit" value="Action" name="genreSection" class="<?php echo $actionActive ?>">ACTION</button>
            <button type="submit" value="Drama" name="genreSection" class="<?php echo $dramaActive ?>">DRAMA</button>
            <button type="submit" value="Educational" name="genreSection" class="<?php echo $educationalActive ?>">EDUCATIONAL</button>
        </form>

        <?php 
            if (isset($_GET['genreSection'])) {
                
                $genreSelection = $_GET['genreSection'];

                $sqlGetPostDetails = "SELECT 
                                        post.*, 
                                        reader.*, 
                                        book.*, 
                                        AVG(comment.rating) AS averageRating
                                    FROM post_review post
                                    INNER JOIN reader_user reader USING (readerID)
                                    INNER JOIN book_record book USING (bookID)
                                    LEFT JOIN comment_rating comment USING (postCode)
                                    WHERE post.statusApprove != 'BANNED' AND
                                        post.statusApprove != 'SUSPICIOUS' AND
                                        post.genre LIKE '%$genreSelection%'
                                    GROUP BY post.postCode
                                    ORDER BY averageRating DESC, post.datePosted DESC";
                $resultGetPostDetails = $conn->query($sqlGetPostDetails);
                $post = $resultGetPostDetails->fetch_all(MYSQLI_ASSOC);

                include 'genreSection.php';

            } else {

                echo '<table class="genre-table">';  
                echo '    <thead>';  
                echo '        <tr>';  
                echo '            <th>TITLE</th>';  
                echo '            <th>REVIEWS</th>';  
                echo '        </tr>';  
                echo '    </thead>';  
                echo '    <tbody>';  
                echo '        <tr>';  
                echo '            <td>&nbsp;</td>';  
                echo '            <td>&nbsp;</td>';  
                echo '        </tr>';  
                echo '        <tr>';  
                echo '            <td>&nbsp;</td>';  
                echo '            <td>&nbsp;</td>';  
                echo '        </tr>';  
                echo '        <tr>';  
                echo '            <td>&nbsp;</td>';  
                echo '            <td>&nbsp;</td>';  
                echo '        </tr>';  
                echo '        <tr>';  
                echo '            <td>&nbsp;</td>';  
                echo '            <td>&nbsp;</td>';  
                echo '        </tr>';  
                echo '        <tr>';  
                echo '            <td>&nbsp;</td>';  
                echo '            <td>&nbsp;</td>';  
                echo '        </tr>';  
                echo '    </tbody>';  
                echo '</table>';  

                echo '<div class="pagination">';  
                echo '    <button>';  
                echo '        &lt;';  
                echo '    </button>';  
                echo '    <span>1</span>';  
                echo '    <button>&gt;</button>';  
                echo '</div>';
        }
        ?>

    </main>

    <?php include("footer.html"); ?>

</body>

</html>