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
                    <h1>Reports</h1>
                </div>

                <?php
                $fetchReports = "SELECT * FROM student_reports INNER JOIN student_registration ON student_registration.studentEmail = student_reports.studentEmail ORDER BY reportDate DESC";

                $result = $connect->query($fetchReports);

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

                        <div class="comment-box">
                            <a href="view-report.php?reportID=<?php echo $row['reportID']; ?>" class="comment-btn">View Report</a>
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

                <div class="report-btn" id="myBtn">
                    <button>
                        <img src="assets/images/pen.png" alt="">
                        <span>Report a case</span>
                    </button>
                </div>
            </div>

            <div id="myModal" class="modal">
                <div class="modal-content">
                    <div class="report-form">
                        <div class="report-top">
                            <img src="assets/images/warning.png" alt="Report Icon" width="25">
                            <h1 class="title">Report A Case</h1>
                        </div>
                        <form action="process-report.php" method="post" enctype="multipart/form-data">
                            <p>Report About:</p>
                            <select name="report_about">
                                <option value="">-- select --</option>
                                <option value="Bullying">Bullying</option>
                                <option value="Verbal Abuse">Verbal Abuse</option>
                                <option value="Harassment">Harassment</option>
                                <option value="Physical Violence">Physical Violence</option>
                                <option value="Sexual Assault">Sexual Assault</option>
                                <option value="Discrimination">Discrimination</option>
                                <option value="Cyberbullying">Cyberbullying</option>
                                <option value="Emotional Abuse">Emotional Abuse</option>
                            </select>
                            <p>If others please specify:</p>
                            <input type="text" name="report_about" class="others">
                            <p>Description:</p>
                            <textarea name="report_desc" rows="5" required></textarea>
                            <p>Incident happened in:</p>
                            <div class="radio">
                                <div class="radio-input"><input type="radio" name="location" id="inside" value="Inside" checked><label for="inside">Inside Campus</label></div>
                                <div class="radio-input"><input type="radio" name="location" id="outside" value="Outside"><label for="outside">Outside Campus</label></div>
                                <div class="radio-input"><input type="radio" name="location" id="both" value="Inside and Outside"><label for="both">Inside and Outside Campus</label></div>
                            </div>
                            <div class="image-upload">
                                <p>Upload an image (optional):</p>
                                <input type="file" name="img-proof">
                            </div>
                            <div class="anonymous">
                                <input type="checkbox" name="anonymous" id="anonymous">
                                <label for="anonymous">Report anonymously</label>
                            </div>

                            <div class="bottom-btn">
                                <button type="button" class="close">Cancel</button>
                                <input type="submit" name="submit-report" class="submit-btn" value="Submit Report">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>

        <script>
            var modal = document.getElementById("myModal");
            var btn = document.getElementById("myBtn");
            var span = document.getElementsByClassName("close")[0];

            btn.onclick = function() {
                modal.style.display = "block";
            }

            // close button
            span.onclick = function() {
                modal.style.display = "none";
            }


            $(document).ready(function() {
        // Enable "If others please specify" input initially
        $('.others').prop('disabled', false);

        // When the select option changes
        $('select[name="report_about"]').change(function() {
            // Check if the selected option is not empty
            if ($(this).val() !== '') {
                // If a value is selected, disable the text input
                $('.others').prop('disabled', true);
            } else {
                // If no value is selected, enable the text input
                $('.others').prop('disabled', false);
            }
        });

        // When typing in the "If others please specify" input
        $('.others').on('input', function() {
            // Check if the input has some text
            if ($(this).val().trim() !== '') {
                // If there's text, disable the select option
                $('select[name="report_about"]').prop('disabled', true);
            } else {
                // If no text, enable the select option
                $('select[name="report_about"]').prop('disabled', false);
            }
        });
    });


        </script>
    </body>
    </html>