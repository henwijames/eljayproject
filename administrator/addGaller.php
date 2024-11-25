<?php
include '../functions/conn.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieving form data
    $achievement_id = $_POST['achievement_id'];  // Assuming this is a hidden field or auto-generated
    $motto = $_POST['motto'];
    $profile_pic = ''; // Initialize to empty string
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename']; // Corrected 'middelname' to 'middlename'
    $lastname = $_POST['lastname'];
    $birthdate = $_POST['birthdate'];
    $present_address1 = $_POST['present_address'];
    $course = $_POST['course'];
    $batch = $_POST['batch'];
    $courseid = $_POST['courseid'];
    $batchid = $_POST['batchid'];

    // Ensure uploads directory exists
    $upload_dir = '../student/images/';
    if (!file_exists($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // Handle the file upload
    if (!empty($_FILES['profile_pic']['name'])) {
        if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $fileName = $_FILES['profile_pic']['name'];
            $fileTmpName = $_FILES['profile_pic']['tmp_name'];
            $filePath = $upload_dir . basename($fileName);

            // Validate file type (JPG, PNG, GIF)
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($file_extension, $allowed_extensions)) {
                die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
            }

            // Validate file size (max size: 5MB)
            if ($_FILES['profile_pic']['size'] > 5000000) { // 5MB
                die("File is too large. Maximum size is 5MB.");
            }

            // Move the uploaded file to the desired directory
            if (move_uploaded_file($fileTmpName, $filePath)) {
                $profile_pic = $fileName; // Successfully uploaded file
            } else {
                die("Failed to move uploaded file.");
            }
        } else {
            die("File upload error: " . $_FILES['profile_pic']['error']);
        }
    }
    
    // Insert data into the database
    $sql = "INSERT INTO `alumnigallery` (`FIRSTNAME`, `MIDDLENAME`, `LASTNAME`, `BIRTHDATE`, `ADDRESS`, `COURSE`, `BATCHDATE`, `MOTTO`, `IMAGE`,`ACHIEVEMENT_ID`) 
            VALUES ('$firstname', '$middlename', '$lastname', '$birthdate', '$present_address1', '$course', '$batch', '$motto', '$profile_pic', '$achievement_id')";

    if (mysqli_query($conn, $sql)) {
        $_SESSION['stat'] = "success";
        $_SESSION['msg'] = "Student added successfully!";
    } else {
        $_SESSION['stat'] = "error";
        $_SESSION['msg'] = "Failed to add student: " . mysqli_error($conn);

    }
    header("Location: gallery.php?course=$courseid&batch=$batchid");

}
?>
