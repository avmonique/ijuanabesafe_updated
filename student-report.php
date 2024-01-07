<?php
    include "config.php";
    session_start();

    if (empty($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }

    $student_email = $_SESSION["email"];
    $fetchReports = "SELECT * FROM student_reports
                 INNER JOIN student_registration ON student_registration.studentEmail = student_reports.studentEmail
                 WHERE student_reports.studentEmail = '$student_email'
                 ORDER BY reportDate DESC"; // Assuming reportDate is the column holding the date reported

    $result = $connect->query($fetchReports);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IJuanaBeSafe | Report</title>
    <link rel="shortcut icon" href="assets/images/logoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/student_report.css">
</head>
<body>
    <aside class="navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <img src="assets/images/logowithname.png" alt="IJuanaBeSafe Logo">
            </div>
            <nav>
                <a href="student-home.php">
                    <button>
                        <img src="assets/images/homeIcon.png" alt="Home Icon">
                        <span>Home</span>
                    </button>
                </a>
                <a href="student-report.php" class="active">
                    <button>
                        <img src="assets/images/writereportIcon.png" alt="Report Icon">
                        <span>My Reports</span>
                    </button>
                </a>
                <a href="student-message.php">
                    <button>
                        <img src="assets/images/messageIcon.png" alt="Message Icon">
                        <span>Messages</span>
                    </button>
                </a>
            </nav>
        </div>
    </aside>
    

    <main class="content">
        <div class="content-container">
            <div class="top-content">
                <h1>My Reports</h1>
            </div>

            <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        // Extract details for each report here
                        $studentID = $row['studentID'];
                        $studentName = $row['firstname'] . " " . $row['lastname'];
                        $studentYear = $row['yearLevel'];
                        $studentProgram = $row['program'];
                        $studentCampus = $row['campus'];
                        $reportAbout = $row['reportAbout'];
                        $reportDesc = $row['reportDescription'];
                        $loc = $row['location'];
                        $pic = $row['pic_path'];
                        $dateReported = $row['reportDate'];
                        $formattedDate = date('F d, Y \a\t g:i A', strtotime($dateReported));

                        // Display each report here
                        echo "
                            <div class='report-card'>
                                <div class='report-container'>
                                    <div class='report-content'>
                                        <h4>Student ID:</h4>
                                        <p>$studentID</p>
                                        <h4>Reported by:</h4>
                                        <p>$studentName</p>
                                        <h4>Year Level/Program:</h4>
                                        <p>$studentYear - $studentProgram</p>
                                        <h4>Campus:</h4>
                                        <p>$studentCampus</p>
                                        <h4>Report about:</h4>
                                        <p>$reportAbout</p>
                                        <h4>Location:</h4>
                                        <p>$loc</p>
                                        <h4>Description:</h4>
                                        <p>$reportDesc</p>
                                        <p class='dateRep'><span>Date Reported:</span><span class='date'> $formattedDate</span></p>
                                        <img src='$pic'  width='100%' style='border-radius: 5px; margin-top: 10px;'>
                                    </div>
                                </div>
                            </div>";
                    }
                } else {
                    echo "No reports available";
                }
            ?>
        </div>
    </main>
</body>
</html>