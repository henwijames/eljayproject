<?php
session_start(); // Start the session to use session variables

require_once '../connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the form inputs
    $studentId = $_POST['student_id'];
    $achievementId = $_POST['achievement_id'];
    $motto = $_POST['moto'];
    $profilePic = $_FILES['profile_pic'];

    // Prepare the SQL update statement
    $sql = "UPDATE students SET achievement_id = :achievement_id, moto = :moto";

    // Add profile picture handling
    if (!empty($profilePic['name'])) {
        // Define the directory to save the uploaded file
        $targetDir = '../uploads/'; // Ensure this directory exists and is writable
        $targetFile = $targetDir . basename($profilePic['name']);
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a valid image type
        $check = getimagesize($profilePic['tmp_name']);
        if ($check === false) {
            $_SESSION['error'] = "File is not an image.";
            header("Location: ../path/to/your/form.php"); // Redirect back with error
            exit();
        }

        // Allow certain file formats
        $allowedFormats = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedFormats)) {
            $_SESSION['error'] = "Only JPG, JPEG, PNG, and GIF files are allowed.";
            header("Location: ../path/to/your/form.php");
            exit();
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($profilePic['tmp_name'], $targetFile)) {
            // Append the file path to the SQL statement
            $sql .= ", profile_pic = :profile_pic";
        } else {
            $_SESSION['error'] = "There was an error uploading your file.";
            header("Location: ../path/to/your/form.php");
            exit();
        }
    }

    $sql .= " WHERE id = :student_id";

    try {
        // Prepare the statement
        $stmt = $db->prepare($sql);
        
        // Bind parameters
        $stmt->bindParam(':achievement_id', $achievementId, PDO::PARAM_INT);
        $stmt->bindParam(':moto', $motto, PDO::PARAM_STR);
        $stmt->bindParam(':student_id', $studentId, PDO::PARAM_INT);

        // Bind profile picture path if uploaded
        if (!empty($profilePic['name'])) {
            $stmt->bindParam(':profile_pic', $targetFile, PDO::PARAM_STR);
        }

        // Execute the statement
        if ($stmt->execute()) {
            $_SESSION['success'] = "Student information updated successfully.";
        } else {
            $_SESSION['error'] = "Failed to update student information.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    // Redirect back to the form or gallery page
    header("Location: ../path/to/your/form.php"); // Adjust this to your specific location
    exit();
} else {
    // Handle the case when the script is accessed without a POST request
    $_SESSION['error'] = "Invalid request method.";
    header("Location: ../path/to/your/form.php");
    exit();
}
?>
