<?php
include "config.php";
session_start();
if (empty($_SESSION["email"])) {
    header("Location: login.php");
    exit();
}

$email = $_SESSION["email"];
$coorName = "";
$coorCampus = "";

$getData = "SELECT * FROM coordinators WHERE coorEmail = '$email'";
$result = $connect->query($getData);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $coorName = $row['coorFirstname'] . " " . $row['coorLastname'];
        $coorCampus = $row['coorCampus'];
    }
}

// Fetching data for Pie Chart 1 (Report About)
$reportAboutData = [];
$reportAboutQuery = "SELECT reportAbout, COUNT(*) as count FROM student_reports WHERE reportAbout <> '' GROUP BY reportAbout";
$reportAboutResult = $connect->query($reportAboutQuery);

if ($reportAboutResult->num_rows > 0) {
    while ($row = $reportAboutResult->fetch_assoc()) {
        $reportAboutData[] = [$row['reportAbout'], (int)$row['count']];
    }
}

// Fetching data for Pie Chart 2 (Location)
$locationData = [];
$locationQuery = "SELECT location, COUNT(*) as count FROM student_reports WHERE location <> '' GROUP BY location";
$locationResult = $connect->query($locationQuery);

if ($locationResult->num_rows > 0) {
    while ($row = $locationResult->fetch_assoc()) {
        $locationData[] = [$row['location'], (int)$row['count']];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IJuanaBeSafe | Analytics</title>
    <link rel="shortcut icon" href="assets/images/logoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/coor_nav.css">
    <link rel="stylesheet" href="assets/css/coor_analytics.css">
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);
        google.charts.setOnLoadCallback(drawChart2);

        function drawChart() {
            var reportAboutData = <?php echo json_encode($reportAboutData); ?>;
            var data = google.visualization.arrayToDataTable([
                ['Report About', 'Count'],
                <?php
                foreach ($reportAboutData as $data) {
                    echo "['" . $data[0] . "', " . $data[1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Report About',
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart'));

            chart.draw(data, options);
        }

        function drawChart2() {
            var locationData = <?php echo json_encode($locationData); ?>;
            var data = google.visualization.arrayToDataTable([
                ['Location', 'Count'],
                <?php
                foreach ($locationData as $data) {
                    echo "['" . $data[0] . "', " . $data[1] . "],";
                }
                ?>
            ]);

            var options = {
                title: 'Location'
            };

            var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

            chart.draw(data, options);
        }
    </script>
</head>
<body>
    <aside class="navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <img src="assets/images/logowithname.png" alt="IJuanaBeSafe Logo">
            </div>
            <!-- <div class="profile">
                <p class="coor-name">John Doe</p>
                <p class="campus">Urdaneta Campus</p>
            </div> -->
            
            <nav>
                <a href="coor-reports.php">
                    <button>
                        <img src="assets/images/studReportsIcon.png" alt="Report Icon">
                        <span>Student Reports</span>
                    </button>
                </a>
                <a href="coor-analytics.php"  class="active">
                    <button>
                        <img src="assets/images/analyticsIcon.png" alt="Report Icon">
                        <span>Report Analytics</span>
                    </button>
                </a>
                <a href="coor-message.php">
                    <button>
                        <img src="assets/images/messageIcon.png" alt="Message Icon">
                        <span>Messages</span>
                    </button>
                </a>
                
                
            </nav>

            <a href="logout.php">
                <button class="logout">
                    <img src="assets/images/logoutIcon.png" alt="Message Icon">
                    <span>Logout</span>
                </button>
            </a>
        </div>
    </aside>
    

    <main class="content">
        <div class="content-container">
            <div class="analytics-card">
                <h1>Report Data Analytics</h1>
                <div id="piechart" style="width: 500px; height: 550px; float: left;"></div>
                <div id="piechart2" style="width: 500px; height: 550px; float: right;"></div>
            </div>
        </div>
    </main>
</body>
</html>