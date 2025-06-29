<?php 
session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
    exit;
}

require("database/database.php");

$username = $_SESSION['username'];
$readerID = $_SESSION['readerID'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
    OR email = '$username' OR phone = '$username'";
$runSQL = $conn->query($sql);
$user = $runSQL->fetch_assoc();

// Most Borrowed Books
$sqlBorrowed = "SELECT br.bookTitle AS title, COUNT(br.bookID) AS borrow_count
    FROM book_borrowed bb
    JOIN post_review pr ON bb.postCode = pr.postCode
    JOIN book_record br ON pr.bookID = br.bookID
    GROUP BY br.bookID
    ORDER BY borrow_count DESC
    LIMIT 5";
$borrowedResult = $conn->query($sqlBorrowed);
$borrowedData = [];
while ($row = $borrowedResult->fetch_assoc()) {
    $borrowedData[] = $row;
}

// Highest Rated Books
$sqlRated = "
    SELECT br.bookTitle, AVG(cr.rating) AS avgRating
    FROM book_record br
    JOIN post_review pr ON br.bookID = pr.bookID
    JOIN comment_rating cr ON pr.postCode = cr.postCode
    GROUP BY br.bookTitle
    ORDER BY avgRating DESC
    LIMIT 5";
$highestRatedResult = $conn->query($sqlRated);

// Most Active Users
$sqlActive = "
    SELECT ru.username, 
           (
               (SELECT COUNT(*) FROM post_review pr WHERE pr.readerID = ru.readerID) +
               (SELECT COUNT(*) FROM comment_rating cr WHERE cr.readerID = ru.readerID)
           ) AS totalActivity
    FROM reader_user ru
    ORDER BY totalActivity DESC
    LIMIT 5";
$activeUsersResult = $conn->query($sqlActive);
?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">
<head>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <?php include("headDetails.html"); ?>
    <title>User Insights</title>
    <style>
        main {
            margin: 50px auto;
            max-width: 90%;
            text-align: center;
        }
        .insights-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
        }
        .insights-buttons button {
            width: 200px;
            padding: 10px 0;
            font-weight: bold;
            border-radius: 30px;
            border: 2px solid #d4d4d4;
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
            cursor: pointer;
            transition: 0.2s;
        }
        .insights-buttons button:hover {
            background-color: var(--buttonHoverColor);
        }
        .insights-buttons button.active {
            background-color: lightgray;
            border: 2px solid gray;
        }
        .insight-table {
            width: 60%;
            margin: 0 auto 40px auto;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.15);
            table-layout: fixed;
        }

        .insight-table th, .insight-table td {
            width: 50%;
            padding: 12px 10px;
            text-align: center;
            font-size: 16px;
            border: 1px solid #ddd;
            color: black;
            word-wrap: break-word;
        }

        .insight-table th, .insight-table td {
            padding: 12px 10px;
            text-align: center;
            font-size: 16px;
            border: 1px solid #ddd;
            color: black;
        }
        .insight-table th {
            background-color: #acaedeec;
        }
        .insight-table td {
            background-color: white;
        }
        canvas {
            max-width: 500px;
            margin: auto;
        }
    </style>
</head>
<body>
<?php include("header.php"); ?>

<main>
    <div class="insights-buttons">
        <button id="btn-rated" class="active" onclick="toggleSection('rated')">Highest Rated</button>
        <button id="btn-active" onclick="toggleSection('active')">Most Active</button>
        <button id="btn-borrowed" onclick="toggleSection('borrowed')">Most Borrowed</button>
    </div>

    <!-- Highest Rated Books -->
    <table class="insight-table" id="table-rated">
        <thead><tr><th>BOOK TITLE</th><th>AVERAGE RATING</th></tr></thead>
        <tbody>
        <?php $rank = 1;
        while ($row = $highestRatedResult->fetch_assoc()) {
            echo "<tr><td>{$rank}. {$row['bookTitle']}</td><td>" . number_format($row['avgRating'], 2) . "</td></tr>";
            $rank++;
        } ?>
        </tbody>
    </table>

    <!-- Most Active Users -->
    <table class="insight-table" id="table-active" style="display:none;">
        <thead><tr><th>USERNAME</th><th>TOTAL POSTS & REVIEWS</th></tr></thead>
        <tbody>
        <?php $rank = 1;
        while ($row = $activeUsersResult->fetch_assoc()) {
            echo "<tr><td>{$rank}. {$row['username']}</td><td>{$row['totalActivity']}</td></tr>";
            $rank++;
        } ?>
        </tbody>
    </table>

    <!-- Most Borrowed Books -->
    <table class="insight-table" id="table-borrowed" style="display:none;">
        <thead><tr><th>BOOK TITLE</th><th>TOTAL BORROWED</th></tr></thead>
        <tbody>
        <?php foreach ($borrowedData as $index => $row): ?>
            <tr>
                <td><?= ($index + 1) . ". " . htmlspecialchars($row['title']) ?></td>
                <td><?= $row['borrow_count'] ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <canvas id="borrowChart" style="display:none;"></canvas>
</main>

<script>
function toggleSection(type) {
    document.getElementById("table-borrowed").style.display = type === 'borrowed' ? 'table' : 'none';
    document.getElementById("borrowChart").style.display = type === 'borrowed' ? 'block' : 'none';
    document.getElementById("table-rated").style.display = type === 'rated' ? 'table' : 'none';
    document.getElementById("table-active").style.display = type === 'active' ? 'table' : 'none';

    document.getElementById("btn-borrowed").classList.remove('active');
    document.getElementById("btn-rated").classList.remove('active');
    document.getElementById("btn-active").classList.remove('active');
    document.getElementById("btn-" + type).classList.add('active');
}

const borrowChart = new Chart(document.getElementById('borrowChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($borrowedData, 'title')) ?>,
        datasets: [{
            label: 'Books Borrowed',
            data: <?= json_encode(array_column($borrowedData, 'borrow_count')) ?>,
            backgroundColor: 'rgba(100, 137, 196, 0.74)',
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Most Borrowed Books'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1,
                    precision: 0
                }
            }
        }
    }
});
</script>

<?php include("footer.html"); ?>
</body>
</html>
