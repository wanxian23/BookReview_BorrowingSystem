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

// Fetch book borrow data
$chartLabels = [];
$chartData = [];

$sqlChart = "SELECT book_record.bookTitle AS title, COUNT(book_record.bookID) AS borrow_count
             FROM book_borrowed
             JOIN post_review ON book_borrowed.postCode = post_review.postCode
             JOIN book_record ON post_review.bookID = book_record.bookID
             GROUP BY book_record.bookID
             ORDER BY borrow_count DESC
             LIMIT 5";


$resultChart = $conn->query($sqlChart);

if ($resultChart && $resultChart->num_rows > 0) {
    while ($row = $resultChart->fetch_assoc()) {
        $chartLabels[] = $row['title'];
        $chartData[] = $row['borrow_count'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Most Borrowed Books</title>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="icon" href="image/logo.png">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <style>
        {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            height: 100%;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #fdf4cc;
            overflow-x: hidden;
        }

        .chart-container {
            width: 90%;
            max-width: 700px;
            margin: 60px auto 80px auto;
            padding: 20px;
            background-color: #fff8e7;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        canvas {
            width: 100% !important;
            height: auto !important;
        }


        #firstHeader {
            box-shadow: none;
        }
        </style>


</head>
<body>

<?php include("header.php"); ?>

<div class="chart-container">
    <canvas id="myBarChart"></canvas>
</div>

<script>
    const ctx = document.getElementById('myBarChart').getContext('2d');
    const myBarChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chartLabels); ?>,
            datasets: [{
                label: 'Books Borrowed',
                data: <?= json_encode($chartData); ?>,
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
                },
                legend: {
                    display: true
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
