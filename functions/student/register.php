<?php
include_once '../connection.php';
require_once 'phpqrcode/qrlib.php'; 

$path = 'qrcodes/';
if (!is_dir($path)) {
    mkdir($path, 0777, true); // Ensure the directory exists
}

$qrcode = $path . time() . ".png";
$qrimage = time() . ".png";

// Sanitize and hash input
$username = trim(filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS));
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$firstname = trim(filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS));
$lastname = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS));
$birthdate = $_POST['birthdate'];
$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
$course = intval($_POST['course']);
$civil = trim(filter_var($_POST['civil'], FILTER_SANITIZE_SPECIAL_CHARS));
$batch = intval($_POST['batch']);
$phone = trim(filter_var($_POST['phone'], FILTER_SANITIZE_SPECIAL_CHARS));

$profile_pic = '../../assets/img/person.png'; // Path to the default profile picture


// Handle file upload
$file = $_FILES['file'];
$allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
$maxSize = 2 * 1024 * 1024; // 2 MB

if ($file['error'] === UPLOAD_ERR_OK) {
    if (in_array($file['type'], $allowedTypes) && $file['size'] <= $maxSize) {
        $uploadDir = '../../administrator/files/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Ensure the directory exists
        }
        $filePath = $uploadDir . basename($file['name']);
        if (move_uploaded_file($file['tmp_name'], $filePath)) {
            $file = basename($file['name']);
        } else {
            echo "Error moving uploaded file.";
            exit;
        }
    } else {
        echo "Invalid file type or file too large.";
        exit;
    }
} else {
    echo "File upload error.";
    exit;
}

$status = 'pending';

$sql = "SELECT * FROM `users` WHERE `username` = :username";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    echo "Username '$username' already exists!";
    exit;
}

// Insert into users table
$sql = "INSERT INTO `users` (`username`, `password`) VALUES (:username, :password)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);

if ($stmt->execute()) {
    $user_id = $db->lastInsertId();
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error inserting user: " . $errorInfo[2];
    exit;
}

// Get the selected major ID from the form
$major_id = isset($_POST['majors']) ? intval($_POST['majors'][0]) : null; // Get the first selected major ID

// Insert into students table
$sql = "INSERT INTO `students` (user_id, `firstname`, `lastname`, `birthdate`, `email`, `course`, `civil`, `batch`, `phone`, `file`, `qrimage`, `major_id`, `profile_pic`) 
        VALUES (:user_id, :firstname, :lastname, :birthdate, :email, :course, :civil, :batch, :phone, :file, :qrimage, :major_id, :profile_pic)";
$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':course', $course);
$stmt->bindParam(':civil', $civil);
$stmt->bindParam(':batch', $batch);
$stmt->bindParam(':phone', $phone);
$stmt->bindParam(':file', $file);
$stmt->bindParam(':qrimage', $qrimage);
$stmt->bindParam(':major_id', $major_id);
$stmt->bindParam(':profile_pic', $profile_pic);

if ($stmt->execute()) {
    QRcode::png($username, $qrcode, 'H', 4, 4);
    header('Location: ../../index.php?type=success&message=' . urlencode('Successfully Registered - Please check your email and wait for the administrators approval. '));
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error inserting student: " . $errorInfo[2];
    exit;
}

// Close the connection
$db = null;
?>
