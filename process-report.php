<?php
    include "config.php";
    session_start();
    
    if (isset($_POST["submit-report"])) {
        $studentEmail = $_SESSION['email'];
        $reportAbout = $_POST['report_about'];
        $reportDescription = $_POST['report_desc'];
        $location = $_POST['location'];
        $anonymous = isset($_POST['anonymous']) ? 'on' : 'off';
    
        $targetDirectory = "images/";
    
        if (!empty($_FILES["img-proof"]["name"])) {
            $targetFile = $targetDirectory . basename($_FILES["img-proof"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
            if ($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "png") {
                $errorMessage = "Sorry, only JPG, JPEG, and PNG files are allowed.";
                $uploadOk = 0;
            }
    
            if ($uploadOk) {
                if (move_uploaded_file($_FILES["img-proof"]["tmp_name"], $targetFile)) {
                    $stmt = $connect->prepare("INSERT INTO student_reports (studentEmail, reportAbout, reportDescription, location, pic_path, reportDate, postAnonymous) VALUES (?, ?, ?, ?, ?, NOW(), ?)");
                    $stmt->bind_param("ssssss", $studentEmail, $reportAbout, $reportDescription, $location, $targetFile, $anonymous);
    
                    if ($stmt->execute()) {
                        header("Location: student-home.php");
                        exit();
                    } else {
                        $errorMessage = "Error creating record: " . $stmt->error;
                    }
    
                    $stmt->close();
                } else {
                    $errorMessage = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $stmt = $connect->prepare("INSERT INTO student_reports (studentEmail, reportAbout, reportDescription, location, reportDate, postAnonymous) VALUES (?, ?, ?, ?, NOW(), ?)");
            $stmt->bind_param("sssss", $studentEmail, $reportAbout, $reportDescription, $location, $anonymous);
    
            if ($stmt->execute()) {
                header("Location: student-home.php");
                exit();
            } else {
                $errorMessage = "Error creating record: " . $stmt->error;
            }
    
            $stmt->close();
        }
    }
    
?>