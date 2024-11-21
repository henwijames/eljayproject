<?php
include_once '../connection.php';
require_once 'phpqrcode/qrlib.php';

$path = 'qrcodes/';
if (!is_dir($path)) {
    mkdir($path, 0777, true); // Ensure QR code directory exists
}

// Assuming `user_id` is provided in POST for updating existing records
$user_id = isset($_POST['user_id']) ? intval($_POST['user_id']) : null;

if (!$user_id) {
    echo "Error: No user ID provided for update.";
    exit;
}

// Sanitize and validate input fields
$firstname = trim(filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS));
$lastname = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS));
$birthdate = DateTime::createFromFormat('Y-m-d', $_POST['birthdate']) ? $_POST['birthdate'] : null;
$course = intval($_POST['course']);
$civil = trim(filter_var($_POST['civil'], FILTER_SANITIZE_SPECIAL_CHARS));
$batch = intval($_POST['batch']);
$present_address = trim(filter_var($_POST['present_address'], FILTER_SANITIZE_SPECIAL_CHARS));

// Generate or update QR Code and set path
$qrcode = $path . 'user' . $user_id . '.png';
QRcode::png($user_id, $qrcode, 'H', 4, 4);

if (!file_exists($qrcode)) {
    echo "Error: QR code generation failed.";
    exit;
}

// Update `users` table for username and password (if needed)
$username = 'user' . rand(1000, 9999);
$password = password_hash('pass' . rand(1000, 9999), PASSWORD_DEFAULT);

$sql = "UPDATE `users` SET `username` = :username, `password` = :password WHERE `id` = :user_id";
$stmt = $db->prepare($sql);
$stmt->bindParam(':username', $username);
$stmt->bindParam(':password', $password);
$stmt->bindParam(':user_id', $user_id);

if (!$stmt->execute()) {
    $errorInfo = $stmt->errorInfo();
    echo "Error updating user: " . $errorInfo[2];
    exit;
}

// Handle major selection if applicable
$major_id = isset($_POST['majors']) ? intval($_POST['majors'][0]) : null;

// Update `students` table with the new information
$sql = "UPDATE `students` SET 
            `firstname` = :firstname, 
            `lastname` = :lastname, 
            `birthdate` = :birthdate, 
            `present_address` = :present_address, 
            `course` = :course, 
            `civil` = :civil, 
            `batch` = :batch, 
            `qrimage` = :qrimage, 
            `major_id` = :major_id,
            `alumni_status` = 'active'
        WHERE `user_id` = :user_id";
        
$stmt = $db->prepare($sql);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':present_address', $present_address);
$stmt->bindParam(':course', $course);
$stmt->bindParam(':civil', $civil);
$stmt->bindParam(':batch', $batch);
$stmt->bindParam(':qrimage', $qrcode);
$stmt->bindParam(':major_id', $major_id);
$stmt->bindParam(':user_id', $user_id);

if ($stmt->execute()) {
    header('Location: ../../administrator/gallery.php?type=success&message=' . urlencode('Successfully Updated - Your profile has been updated.'));
    exit;
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error updating student: " . $errorInfo[2];
    exit;
}

// Close the connection
$db = null;
?>
