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

    $fetchReports = "SELECT * FROM student_reports INNER JOIN student_registration ON student_registration.studentEmail = student_reports.studentEmail WHERE student_registration.campus = '$coorCampus' ORDER BY reportDate DESC"; // Assuming reportDate is the column holding the date reported

    $result = $connect->query($fetchReports);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IJuanaBeSafe | Reports</title>
    <link rel="shortcut icon" href="assets/images/logoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/coor_nav.css">
    <link rel="stylesheet" href="assets/css/coor_report.css">
</head>
<body>
    <aside class="navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <img src="assets/images/logowithname.png" alt="IJuanaBeSafe Logo">
            </div>
            <!-- <div class="profile">
                <p class="coor-name"></p>
                <p class="campus"></p>
            </div> -->
            
            <nav>
                <a href="coor-reports.php" class="active">
                    <button>
                        <img src="assets/images/studReportsIcon.png" alt="Report Icon">
                        <span>Student Reports</span>
                    </button>
                </a>
                <a href="coor-analytics.php">
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
            <div class="top-content">
                <h1>STUDENT REPORTS</h1>
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

        <!-- <div class="sidebar">
            <div class="sidebar-container">
                <h3>Filter reports by:</h3>
                <div class="categories">
                    <a href="coor-reports">Bullying</a>
                    <a href="">Harassment</a>
                    <a href="">Physical Violence</a>
                    <a href="">Sexual Assault</a>
                    <a href="">Discrimination</a>
                    <a href="">Cyberbullying</a>
                    <a href="">Emotional Abuse</a>
                </div>
            </div>
        </div> -->
    </main>
</body>
</html>