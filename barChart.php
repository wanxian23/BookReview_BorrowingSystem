<?php 

session_start();

if (!isset($_SESSION['username'], $_SESSION['email'], $_SESSION['contact'])) {
    header("Location: login.php");
    exit;
}

require("database/database.php");

$username = $_SESSION['username'];

$sql = "SELECT * FROM Reader_User WHERE username = '$username'
OR email = '$username' OR phone = '$username'";
$runSQL = $conn->query(query: $sql);

$user = $runSQL->fetch_assoc();

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Free Icon Website -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <!-- put link to jquery library by using google CDN or Microsoft CDN -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- UI jQuery library, which include more animation effect -->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <script src="script.js"></script>

    <link rel="icon" href="image/logo.png">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
  <style>
    body {
      font-family: Arial;
      padding: 0;
      margin: 0;
      background-color: #fdf4cc; 
    }
    .chart-container {
      width: 600px;
      margin: 40px auto 40px auto;
      background: transparent;
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
        labels: ['Book A', 'Book B', 'Book C', 'Book D', 'Book E'],
        datasets: [{
          label: 'Books Borrowed',
          data: [10, 30, 20, 14, 25],
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
            beginAtZero: true
          }
        }
      }
    });
  </script>

  <?php include("footer.html"); ?>

</body>
</html>
