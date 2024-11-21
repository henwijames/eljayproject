<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('Location: administrator/index.php');
    exit;
}

try {
    // Database connection
    $pdo = new PDO('mysql:host=localhost;dbname=lc', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare variables
    $firstname = trim($_POST['firstname']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $work = trim($_POST['work']);  // New field
    $company = trim($_POST['company']);  // New field
    $present_address = trim($_POST['present_address']);
    $profilePic = $_FILES['profile_pic'];

    // Handle file upload
    $profilePicPath = null;
    if ($profilePic['error'] == UPLOAD_ERR_OK) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = strtolower(pathinfo($profilePic['name'], PATHINFO_EXTENSION));

        if (in_array($fileExtension, $allowedExtensions)) {
            $profilePicFilename = uniqid() . '.' . $fileExtension;
            $profilePicPath = 'images/' . $profilePicFilename;
            if (move_uploaded_file($profilePic['tmp_name'], $profilePicPath)) {
                // Save only the filename in the database
                $profilePicPath = $profilePicFilename;
            } else {
                throw new Exception('Failed to move uploaded file.');
            }
        } else {
            throw new Exception('Invalid file type. Only JPG, JPEG, PNG, and GIF files are allowed.');
        }
    }

    // Update student record
    $query = "
        UPDATE students 
        SET firstname = :firstname, 
            lastname = :lastname, 
            email = :email, 
            phone = :phone, 
            work = :work,   -- New field
            company = :company,   -- New field
            present_address = :present_address" . 
            ($profilePicPath ? ", profile_pic = :profile_pic" : "") . 
        " WHERE user_id = (SELECT id FROM users WHERE username = :username)
    ";

    $stmt = $pdo->prepare($query);

    $params = [
        'firstname' => $firstname,
        'lastname' => $lastname,
        'email' => $email,
        'phone' => $phone,
        'work' => $work,  // New field
        'company' => $company,  // New field
        'present_address' => $present_address,
        'username' => $_SESSION['username']
    ];

    if ($profilePicPath) {
        $params['profile_pic'] = $profilePicPath;
    }

    $stmt->execute($params);

    // Redirect to profile page with success message
    header('Location: index.php?update=success');
    exit;
} catch (PDOException $e) {
    // Log the error and redirect to custom error page
    error_log($e->getMessage(), 3, 'errors.log');
    header('Location: error.php?error=db');
    exit;
} catch (Exception $e) {
    // Log the error and redirect to custom error page
    error_log($e->getMessage(), 3, 'errors.log');
    header('Location: error.php?error=generic');
    exit;
}
