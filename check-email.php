<?php
include "config.php";

if (isset($_POST['email'])) {
    $email = $_POST['email'];

    // Check if the email already exists
    $checkEmailQuery = $connect->query("SELECT * FROM student_registration WHERE studentEmail = '$email'");
    if ($checkEmailQuery->num_rows > 0) {
        echo 'exists';
        exit(); // Stop further execution
    }
    // You can also return a different response if the email doesn't exist
    echo 'not_exists';
}
?>
