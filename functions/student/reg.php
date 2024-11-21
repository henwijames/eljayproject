<?php
include_once '../conn.php';

// Function to generate a random username
function generateUsername($firstname, $lastname)
{
    $randomNumber = rand(100, 999);
    return strtolower($firstname . '.' . $lastname . $randomNumber);
}

// Function to generate a random password
function generatePassword($length = 8)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()';
    return substr(str_shuffle($characters), 0, $length);
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form data
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $birthdate = $_POST['birthdate'];
    $present_address = $_POST['present_address'];
    $course_id = $_POST['course'];
    $batch_id = $_POST['batch'];
    $motto = $_POST['motto'];
    $achievement_id = isset($_POST['achievement_id']) && !empty($_POST['achievement_id']) ? $_POST['achievement_id'] : NULL;

    // Set the default statuses
    $status = 'active';
    $alumni_status = 'active';

    // Handle the profile picture upload
    if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] == 0) {
        $profile_pic = $_FILES['profile_pic'];
        $target_dir = "../../student/images/";
        $target_file = basename($profile_pic['name']);
        move_uploaded_file($profile_pic['tmp_name'], $target_dir . $target_file);
    } else {
        $target_file = "default.png";
    }

    // Step 1: Generate random username and password
    $username = generateUsername($firstname, $lastname);
    $password = generatePassword();
    $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hash the password for security

    // Step 2: Insert into `users` table
    $user_sql = "INSERT INTO users (username, password, type, status) VALUES (?, ?, 'student', 'pending')";
    $user_stmt = $conn->prepare($user_sql);
    $user_stmt->bind_param("ss", $username, $hashed_password);

    if ($user_stmt->execute()) {
        // Step 3: Get the ID of the inserted user
        $user_id = $user_stmt->insert_id;

        // Step 4: Insert into `students` table with the `user_id`
        $student_sql = "INSERT INTO students (user_id, firstname, lastname, birthdate, present_address, course, batch, motto, profile_pic, achievement_id, status) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $student_stmt = $conn->prepare($student_sql);
        $student_stmt->bind_param("issssssssss", $user_id, $firstname, $lastname, $birthdate, $present_address, $course_id, $batch_id, $motto, $target_file, $achievement_id, $status);

        if ($student_stmt->execute()) {
            // Success: Redirect or show success message
            header('Location: ../../administrator/gallery.php?type=success&message=' . urlencode('Successfully Registered.'));
        } else {
            echo "<div class='alert alert-danger'>Error in student insertion: " . $student_stmt->error . "</div>";
        }

        $student_stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error in user insertion: " . $user_stmt->error . "</div>";
    }

    // Close the statements and connection
    $user_stmt->close();
    $conn->close();
}
