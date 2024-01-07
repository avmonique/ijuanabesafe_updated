<!-- STUDENT HOME PAGE -->
<?php
    include "config.php";
    session_start();    
    if (empty($_SESSION["email"])) {
        header("Location: login.php");
        exit();
    }
    $student_email = $_SESSION["email"];
    $studentName = "";
    $studentInitials = "";
    $studentCampus = "";
    $dateReported = "";

    $getData = "SELECT * FROM student_registration WHERE studentEmail = '$student_email'";
    $result = $connect->query($getData);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $studentName = $row['firstname'] . " " . $row['lastname'];
            $studentInitials = getInitials($row['firstname'] . " " . $row['lastname']);
            $studentCampus = $row['campus'];
            $studentProgram = $row['program'];
        }
    }

    function getInitials($name) {
        $words = explode(" ", $name);
        $initials = "";
        foreach ($words as $w) {
            $initials .= $w[0];
        }
        return $initials;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IJuanaBeSafe | Home</title>
    <link rel="shortcut icon" href="assets/images/logoIcon.png" type="image/x-icon">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="assets/css/navbar.css">
    <link rel="stylesheet" href="assets/css/student_home.css">
</head>
<body>
    <aside class="navbar">
        <div class="navbar-container">
            <div class="logo-container">
                <img src="assets/images/logowithname.png" alt="IJuanaBeSafe Logo">
            </div>
            <nav>
                <a href="student-home.php" class="active">
                    <button>
                        <img src="assets/images/homeIcon.png" alt="Home Icon">
                        <span>Home</span>
                    </button>
                </a>
                <a href="student-report.php">
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
            <div class="header">
                <h1>View Report</h1>
            </div>

            <?php
            $viewedReportID = isset($_GET['reportID']) ? $_GET['reportID'] : null;

            $fetchReport = "SELECT * FROM student_reports INNER JOIN student_registration ON student_registration.studentEmail = student_reports.studentEmail WHERE reportID = '$viewedReportID'";

            $result = $connect->query($fetchReport);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
            <div class="report-card">
                <div class="report-container">
                    <div class="report-top-content">
                        <div class="user">
                            <?php 
                                if ($row['postAnonymous'] == "on") {
                                    echo "
                                    <div class='circle-text'>?</div>
                                    <p class='username'>Anonymous</p>
                                    ";
                                } else {
                            ?>
                            <div class="circle-text"><?php echo getInitials($row['firstname'] . " " . $row['lastname']); ?></div>
                            <p class="username"><?php echo $row['firstname'] . " " . $row['lastname']; ?></p>
                            <?php }?>
                        </div>
                        <p class="date"><?php echo date('F d, Y \a\t g:i A', strtotime($row['reportDate'])); ?></p>
                    </div>
                    <div class="report-content">
                        <p><?php echo $row['reportDescription']; ?></p>
                        <?php
                            if ($row['pic_path'] != "") {
                                echo "
                                <div class='image-box'>
                                    <img src='" . $row['pic_path'] . "' width='100%'>
                                </div>";
                            } 
                        ?>
                    </div>
                    <hr style="margin-bottom: 10px">
                    <p style="font-weight: 300; margin-top: 10px">Comments:</p>
                    <?php
                    $fetchComments = "SELECT * FROM report_comments INNER JOIN student_registration ON report_comments.commenterEmail = student_registration.studentEmail WHERE reportID = '$viewedReportID'";
                    $res = $connect->query($fetchComments);

                    if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            ?>
                            
                            <div class="comment-container">
                                <div class="top-comment">
                                    <div class="circle-text"><?php echo getInitials($row['firstname'] . " " . $row['lastname']); ?></div>
                                    <p class="username"><?php echo $row['firstname'] . " " . $row['lastname'] . " says"; ?></p>
                                </div>
                                <div class="student-comment">
                                    <p><?php echo $row['comment']; ?></p>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>

                    <div class="comment-box">
                        <form action="add-comment.php" method="GET">
                            <input type="hidden" name="reportID" value="<?php echo $viewedReportID; ?>">
                            <input type="text" name="comment" placeholder="Write a comment...">
                            <input type="submit" name="addComment" value="Add comment" class="comment-btn">
                        </form>
                    </div>
                </div>
            </div>
            <?php } }?>

            <div class="sidebar-profile">
                <div class="sidebar-container">
                    <div class="profile-avatar"><?php echo $studentInitials; ?></div>
                    <p class="student-fullname"><?php echo $studentName; ?></p>
                    <p class="campus"><?php echo $studentCampus . " Campus"; ?></p>
                    <p class="program"><?php echo $studentProgram; ?></p>
                    <div class="logout">
                        <img src="assets/images/logoutIcon.png" alt="">
                        <a href="logout.php">Logout</a>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>