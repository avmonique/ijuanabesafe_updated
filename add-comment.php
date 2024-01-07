<?php
include "config.php";
session_start();

$viewedReportID = isset($_GET['reportID']) ? $_GET['reportID'] : null;

if (isset($_GET['addComment'])) {
    $email = $_SESSION['email'];
    $student_comment = $_GET['comment'];

    // Prepare the SQL statement using prepared statements
    $query = "INSERT INTO report_comments (reportID, commenterEmail, comment) VALUES (?, ?, ?)";
    
    // Initialize a prepared statement
    $stmt = mysqli_prepare($connect, $query);

    // Bind variables to the prepared statement as parameters
    mysqli_stmt_bind_param($stmt, 'sss', $viewedReportID, $email, $student_comment);

    // Execute the prepared statement
    if (mysqli_stmt_execute($stmt)) {
        header("Location: view-report.php?reportID=$viewedReportID");
    } else {
        echo "Error: " . mysqli_error($connect);
    }

    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($connect);
}
?>
