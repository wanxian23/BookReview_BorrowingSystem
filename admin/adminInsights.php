<?php 
session_start();
if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
    exit();
}

require("../database/database.php");

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$contact = $_SESSION['contact'];

$sql = "SELECT * FROM admin WHERE adminUsername = '$username' OR adminEmail = '$email' OR adminPhone = '$contact'";
$runSQL = $conn->query($sql);
$admin = $runSQL->fetch_assoc();

if (!$admin) {
    echo "Admin not found in the system.";
    exit();
}

// Most Active Users
$sqlActive = "
    SELECT ru.username, 
           (
               (SELECT COUNT(*) FROM post_review pr WHERE pr.readerID = ru.readerID) +
               (SELECT COUNT(*) FROM comment_rating cr WHERE cr.readerID = ru.readerID)
           ) AS totalActivity
    FROM reader_user ru
    ORDER BY totalActivity DESC
    LIMIT 5
";
$activeUsersResult = $conn->query($sqlActive);

// Highest Rated Books
$sqlRated = "
    SELECT br.bookTitle, 
           AVG(cr.rating) AS avgRating
    FROM book_record br
    INNER JOIN post_review pr ON br.bookID = pr.bookID
    INNER JOIN comment_rating cr ON pr.postCode = cr.postCode
    GROUP BY br.bookTitle
    ORDER BY avgRating DESC
    LIMIT 5
";
$highestRatedResult = $conn->query($sqlRated);

// Most Reported Posts (show bookTitle)
$sqlReported = "
    SELECT br.bookTitle, COUNT(*) AS reportCount
    FROM post_report pr
    INNER JOIN post_review po ON pr.postCode = po.postCode
    INNER JOIN book_record br ON po.bookID = br.bookID
    GROUP BY br.bookTitle
    ORDER BY reportCount DESC
    LIMIT 3
";
$mostReportedResult = $conn->query($sqlReported);
$reportData = [];
while ($row = $mostReportedResult->fetch_assoc()) {
    $reportData[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en" data-themeColor="defaultColor" data-fontSize="defaultFontSize">
<head>
    <?php include("headDetails.html"); ?>
    <title>Admin Insights</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        main {
            margin: 50px auto;
            max-width: 90%;
            text-align: center;
        }
        .adminInsights-buttons {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 30px;
            margin-bottom: 30px;
        }
        .adminInsights-buttons button {
            width: 200px;
            padding: 10px 0;
            font-weight: bold;
            border-radius: 30px;
            border: 2px solid #d4d4d4;
            background-color: var(--buttonColor);
            color: var(--buttonFontColor);
            cursor: pointer;
            transition: 0.2s;
            text-align: center;
        }
        .adminInsights-buttons button:hover {
            background-color: var(--buttonHoverColor);
        }
        .adminInsights-buttons button.active {
            background-color: lightgray;
            border: 2px solid gray;
        }
        .insight-table {
            width: 50%;
            margin: 0 auto 40px auto;
            border-collapse: collapse;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 1px 1px 10px 5px rgba(0, 0, 0, 0.15);
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
        .top-rank {
            font-weight: bold;
            background-color: #f5f5f5;
        }
        @media (max-width: 650px) {
            .genre-buttons {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body>
<?php include("adminHeader.php"); ?>

<main>
    <div class="adminInsights-buttons">
        <button id="btn-rated" onclick="toggleTable('rated')">Highest Rated Book</button>
        <button id="btn-active" class="active" onclick="toggleTable('active')">Most Active User</button>
        <button id="btn-reported" onclick="toggleTable('reported')">Most Reported</button>
    </div>

    <!-- Most Active Users -->
    <table class="insight-table" id="table-active">
        <thead><tr><th>USERNAME</th><th>TOTAL POSTS & REVIEWS</th></tr></thead>
        <tbody>
        <?php $rank = 1;
        while ($row = $activeUsersResult->fetch_assoc()) {
            echo "<tr><td>{$rank}. {$row['username']}</td><td>{$row['totalActivity']}</td></tr>";
            $rank++;
        } ?>
        </tbody>
    </table>

    <!-- Highest Rated Books -->
    <table class="insight-table" id="table-rated" style="display:none;">
        <thead><tr><th>BOOK TITLE</th><th>AVERAGE RATING</th></tr></thead>
        <tbody>
        <?php $rank = 1;
        while ($row = $highestRatedResult->fetch_assoc()) {
            echo "<tr><td>{$rank}. {$row['bookTitle']}</td><td>".number_format($row['avgRating'], 2)."</td></tr>";
            $rank++;
        } ?>
        </tbody>
    </table>

    <!-- Most Reported Posts -->
    <table class="insight-table" id="table-reported" style="display:none;">
        <thead><tr><th>BOOK TITLE</th><th>REPORT COUNT</th></tr></thead>
        <tbody>
        <?php foreach ($reportData as $row): ?>
            <tr><td><?= htmlspecialchars($row['bookTitle']) ?></td><td><?= $row['reportCount'] ?></td></tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Bar Graph -->
    <canvas id="reportChart" style="display: none; max-width: 500px; margin: auto;"></canvas>
</main>

<?php include("../footer.html"); ?>

<script>
function toggleTable(type) {
    document.getElementById("table-active").style.display = type === 'active' ? 'table' : 'none';
    document.getElementById("table-rated").style.display = type === 'rated' ? 'table' : 'none';
    document.getElementById("table-reported").style.display = type === 'reported' ? 'table' : 'none';
    document.getElementById("reportChart").style.display = type === 'reported' ? 'block' : 'none';

    document.getElementById("btn-rated").classList.remove('active');
    document.getElementById("btn-active").classList.remove('active');
    document.getElementById("btn-reported").classList.remove('active');

    document.getElementById("btn-" + type).classList.add('active');
}

// Chart.js
const ctx = document.getElementById('reportChart').getContext('2d');
const reportChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($reportData, 'bookTitle')) ?>,
        datasets: [{
            label: 'Report Count',
            data: <?= json_encode(array_column($reportData, 'reportCount')) ?>,
            backgroundColor: '#acaedeec'
        }]
    },
    options: {
        responsive: true,
        scales: {
    y: {
        beginAtZero: true,
        ticks: {
            stepSize: 1,
            precision: 0,
            callback: function(value) {
                return Number.isInteger(value) ? value : null;
            }
        }
    }
}    }
});
</script>
</body>
</html>
