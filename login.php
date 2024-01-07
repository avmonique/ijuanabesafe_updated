<?php
    include "config.php";
    session_start();

    $msg = "";

    if (isset($_POST['login'])) {
        $email = clean_data($_POST['email']);
        $password = clean_data($_POST['password']);

        $checkCoordinatorQuery = $connect->query("SELECT * FROM coordinators WHERE coorEmail = '$email' AND coorPassword = '$password'");

        if ($checkCoordinatorQuery->num_rows == 1) {
            $row = $checkCoordinatorQuery->fetch_array();
            $_SESSION['email'] = $row['coorEmail'];
            $msg = "<span style='color: green; font-size: 13px; font-weight: 400;'>Login successfully! Redirecting to home....</span>";
            header("Refresh: 3 url=coor-reports.php"); // coordinator homepage
        } else {
            $hashed_password = md5($password);
            $checkQuery = $connect->query("SELECT * FROM student_registration WHERE studentEmail='$email' AND password='$hashed_password'");

            if ($checkQuery->num_rows == 1) {
                $row = $checkQuery->fetch_array();
                $_SESSION['email'] = $row['studentEmail'];
                $msg = "<span style='color: green; font-size: 13px; font-weight: 400;'>Login successfully! Redirecting to home....</span>";
                header("Refresh: 3 url=student-home.php");
            } else {
                $msg = "<span style='color: red; font-size: 12px; font-weight: 400;'>Wrong email or password.</span>";
            }
        }
    }

    function clean_data($input){
        $input = htmlspecialchars($input);
        $input = trim($input);
        $input = stripslashes($input);
        return $input;
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IJuanaBeSafe | Login</title>
    <link rel="shortcut icon" href="assets/images/logoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/login-style.css">
</head>
<body>
    <div class="login">
        <div class="login-container">
            <div class="top-content">
                <img src="assets/images/logowithname.png" alt="">
                <p>Cloud-based Gender-based Violence Report Portal for Pangasinan State University</p>
                <h1>Login</h1>
            </div>

            <form action="" method="post">
                <p class="email">Email:</p>
                <input type="text" name="email">
                <p class="password">Password:</p>
                <div class="password-container">
                    <input type="password"  name="password" id="password" class="password-input" required/>
                    <span class="toggle-icon" onclick="togglePasswordVisibility('password', 'toggle-icon')"><img src="assets/images/hidePass.png" alt="hidePassword" class="img-pw"></span>
                </div>
                <?php
                    echo $msg;
                ?>
                <div class="login-btn">
                    <input type="submit" value="Login" name="login">
                </div>
            </form>
            <p class="register">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId, iconClass) {
            const passwordInput = document.getElementById(inputId);
            const icon = document.querySelector('.' + iconClass);

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.innerHTML = '<img src="assets/images/seePassIcon.png" alt="Show Password" class="img-pw">';
            } else {
                passwordInput.type = 'password';
                icon.innerHTML = '<img src="assets/images/hidePass.png" alt="Hide Password" class="img-pw">';
            }
        }
    </script>
</body>
</html>