<?php
    include "config.php";

    $successMsg = "";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $studentId = $_POST['student_ID'];
        $firstname = $_POST['student_firstname'];
        $lastname = $_POST['student_lastname'];
        $campus = $_POST['student_campus'];
        $program = $_POST['student_program'];
        $yearLevel = $_POST['student_year'];
        $studentEmail = $_POST['student_email'];
        $password = md5($_POST['student_password']);
        $confirmPass = md5($_POST['confirm_password']);
        $agreeTerms = $_POST['terms'];
 
        $query = "INSERT INTO student_registration VALUES ('$studentId', '$firstname', '$lastname', '$studentEmail', '$confirmPass', '$campus', '$program', '$yearLevel')";
        
        if (mysqli_query($connect, $query)) {
            $successMsg = "Account registered successfully! Redirecting to login...";
            header("Refresh: 3 url=login.php");
        } else {
            echo "Error: " . $query . "<br>" . $connect->error;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IJuanaBeSafe | Register</title>
    <link rel="shortcut icon" href="assets/images/logoIcon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/register-style.css">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="assets/js/error-reg-handling.js"></script>
    <style>
        .error-border {
            border: 1px solid red !important;
        }
    </style>
</head>
<body>
    <div class="register">
        <div class="register-container">
            <div class="top-content">
                <img src="assets/images/logowithname.png" alt="">
                <p>Cloud-based Gender-based Violence Report Portal for Pangasinan State University</p>
                <h1>Register</h1>
            </div>
            <span style="color: green; font-weight: 500; font-size: 14px;"><?php echo $successMsg; ?></span>
            <form action="register.php" method="post" id="registration-form">
                <p>Student ID:</p>
                <input type="text" name="student_ID" required>
                <h6 id="error-studentid" style="color: red; font-weight: 400; margin-top: 5px;"></h6>
                <p>First name:</p>
                <input type="text" name="student_firstname" required>
                <p>Last name:</p>
                <input type="text" name="student_lastname" required>
                <p>Select campus:</p>
                <select name="student_campus" id="" required>
                    <option value="">-choose a campus-</option>
                    <option value="Alaminos">Alaminos</option>
                    <option value="Asingan">Asingan</option>
                    <option value="Bayambang">Bayambang</option>
                    <option value="Binmaley">Binmaley</option>
                    <option value="Infanta">Infanta</option>
                    <option value="Lingayen">Lingayen</option>
                    <option value="San carlos">San Carlos</option>
                    <option value="Sta maria">Sta. Maria</option>
                    <option value="Urdaneta">Urdaneta</option>
                </select>
                <p>Program:</p>
                <select name="student_program" id="" required>
                    <option value="">-choose a program-</option>
                    <option value="BS Information Technology">BS Information Technology</option>
                    <option value="BS Civil Engineering">BS Civil Engineering</option>
                    <option value="BS Mechanical Engineering">BS Mechanical Engineering</option>
                    <option value="BS Electrical Engineering">BS Electrical Engineering</option>
                    <option value="BS Computer Engineering">BS Computer Engineering</option>
                    <option value="BS Mathematics">BS Mathematics</option>
                    <option value="BS Architecture">BS Architecture</option>
                    <option value="AB English Language">AB English Language</option>
                    <option value="Bachelor of Secondary Education">Bachelor of Secondary Education</option>
                    <option value="Bachelor of Early Childhood Education">Bachelor of Early Childhood Education</option>
                </select>
                <p>Year Level:</p>
                <select name="student_year" id="" required>
                    <option value="">-choose year level-</option>
                    <option value="1st Year">1st Year</option>
                    <option value="2nd Year">2nd Year</option>
                    <option value="3rd Year">3rd year</option>
                    <option value="4th Year">4th Year</option>
                </select>
                <p>Email:</p>
                <input type="text" name="student_email" required>
                <h6 id="error-email" style="color: red; font-weight: 400; margin-top: 5px;"></h6>
                <!-- <span class="req">Use your institutional email.</span> -->
                <p>Password:</p>
                <div class="password-container">
                    <input type="password"  name="student_password" id="password" class="password-input" required/>
                    <span class="toggle-icon" onclick="togglePasswordVisibility('password', 'toggle-icon')"><img src="assets/images/hidePass.png" alt="hidePassword" class="img-pw"></span>
                </div>
                <!-- <span class="req">Password must have minimum of 8 characters length.</span> -->
                <p>Confirm Password:</p>
                <div class="password-container">
                    <input type="password"  name="confirm_password" id="confirm_password" class="password-input" required/>
                    <span class="toggle-icon2" onclick="togglePasswordVisibility('confirm_password', 'toggle-icon2')"><img src="assets/images/hidePass.png" alt="hidePassword" class="img-pw"></span>
                </div>
                <h6 id="error-pw" style="color: red; font-weight: 400; margin-top: 5px;"></h6>
                <div class="terms">
                    <input type="checkbox" name="terms" id="terms">
                    <label for="terms">I agree to the </label>&nbsp;<a id="myBtn">terms and conditions.</a>
                </div>
                
                <div class="reg-btn">
                    <input type="submit" value="Register" name="register" id="registerButton" disabled>
                </div>
            </form>
            <p class="register-bottom">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="terms-top">
                <h1>Terms and Conditions</h1>
                <span class="close">&times;</span>
            </div>
            <div class="terms-content eligibility">
                <h4>1. Eligibility</h4>
                <p>1.1. You must be a current student, faculty member, or staff of Pangasinan State University to register and use this portal.</p>
                <p>1.2. By registering, you affirm that the information provided is accurate and complete.</p>
            </div>
            <div class="terms-content privacy">
                <h4>2. Confidentiality and Privacy</h4>
                <p>2.1. All information submitted through this portal, including personal details and reports of Gender-Based Violence (GBV), will be handled with the utmost confidentiality.</p>
                <p>2.2. Your identity will remain anonymous unless disclosure is required by law or poses an imminent threat to safety.</p>
                <p>2.3. The University reserves the right to take necessary actions to ensure the safety and well-being of the community.</p>
            </div>
            <div class="terms-content guidelines">
                <h4>3. Reporting Guidelines</h4>
                <p>3.1. All reports of GBV should be truthful and accurate to the best of your knowledge.</p>
                <p>3.2. False or misleading reports can lead to disciplinary actions.</p>
            </div>
            <p class="terms-bottom">By registering and using this portal, you acknowledge that you have read, understood, and agreed to abide by these terms and conditions.</p>
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

        // script for terms and conditions modal
        var modal = document.getElementById("myModal");
        var btn = document.getElementById("myBtn");
        var span = document.getElementsByClassName("close")[0];

        btn.onclick = function() {
            modal.style.display = "block";
        }

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }

        // script for agree and register 
        function checkAgreement() {
            const termsCheckbox = document.getElementById("terms");
            const registerButton = document.getElementById("registerButton");

            // Check if the terms checkbox is checked
            if (termsCheckbox.checked) {
                registerButton.disabled = false; // Enable the register button
            } else {
                registerButton.disabled = true; // Disable the register button
            }
        }
        document.getElementById("terms").addEventListener("change", checkAgreement);
    
        
    </script>
</body>
</html>