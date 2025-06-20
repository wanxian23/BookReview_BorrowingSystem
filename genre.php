<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
}

require("database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$email' OR phone = '$contact'";

$runSQL = $conn->query(query: $sql);

$user = $runSQL->fetch_assoc();

?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">

<head>
    <?php include("headDetails.html"); ?>
    <title>Genre</title>

    <style>
        :root {
            --buttonColor: white;
            --buttonFontColor: black;
            --buttonHoverColor: #d4d4d4;

            --tableFontColor: black;
            --tableBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --thBgColor: #acaedeec;
            --tdBgColor: white;
        }

        [data-themeColor="lightColor"] {
            --buttonColor: rgb(237, 237, 237);
            --buttonFontColor: rgb(0, 0, 0);
            --buttonHoverColor: #c3c3c3;

            --tableFontColor: black;
            --tableBoxShadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.225);
            --thBgColor: rgb(209, 208, 208);
            --tdBgColor: white;
        }

        [data-themeColor="darkColor"] {
            --buttonColor: black;
            --buttonFontColor: rgb(221, 221, 221);
            --buttonHoverColor: #414141;

            --tableFontColor: rgb(221, 221, 221);
            --tableBoxShadow: 1px 1px 20px 1px rgba(255, 255, 255, 0.822);
            --thBgColor: black;
            --tdBgColor: rgb(53, 53, 53);
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
            border: 2px solid #d4d4d4;
            border-radius: 20px;
            padding: 10px 20px;
            color: var(--buttonFontColor);
            background-color: var(--buttonColor);
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
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
        <div class="genre-buttons">
            <button>ROMANCE</button>
            <button>HORROR</button>
            <button>FANTASY</button>
            <button>SCI-FI</button>
            <button>THRILLER</button>
            <button>COMEDY</button>
            <button>MYSTERY</button>
            <button>ACTION</button>
            <button>CRIME</button>
            <button>EDUCATIONAL</button>
        </div>

        <table class="genre-table">
            <thead>
                <tr>
                    <th>TITLE</th>
                    <th>REVIEWS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>

        <div class="pagination">
            <button>
                <!-- Escape value for '<' -->
                &lt;
            </button>
            <span>1</span>
            <button>></button>
        </div>
    </main>

    <?php include("footer.html"); ?>

</body>

</html>