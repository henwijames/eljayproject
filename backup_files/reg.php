<?php
include_once '../connection.php';
require_once 'phpqrcode/qrlib.php'; 

$path = 'qrcodes/';
if (!is_dir($path)) {
    mkdir($path, 0777, true); // Ensure the directory exists
}

// Generate random values
$username = 'user' . rand(1000, 9999);
$password = password_hash('pass' . rand(1000, 9999), PASSWORD_DEFAULT);
$email = 'user' . rand(1000, 9999) . '@gmail.com';
$phone = '09' . rand(100000000, 999999999);

// Validate and sanitize input fields
$firstname = trim(filter_var($_POST['firstname'], FILTER_SANITIZE_SPECIAL_CHARS));
$lastname = trim(filter_var($_POST['lastname'], FILTER_SANITIZE_SPECIAL_CHARS));
$birthdate = DateTime::createFromFormat('Y-m-d', $_POST['birthdate']) ? $_POST['birthdate'] : null;
$course = intval($_POST['course']);
$civil = trim(filter_var($_POST['civil'], FILTER_SANITIZE_SPECIAL_CHARS));
$batch = intval($_POST['batch']);
$present_address = trim(filter_var($_POST['present_address'], FILTER_SANITIZE_SPECIAL_CHARS)); // Set this variable if present in the form

// Generate QR Code and set qrimage path
$qrcode = $path . $username . '.png';
QRcode::png($username, $qrcode, 'H', 4, 4);

// Check if QR code file was created
if (!file_exists($qrcode)) {
    echo "Error: QR code generation failed.";
    exit;
}

// Check for existing username
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
$major_id = isset($_POST['majors']) ? intval($_POST['majors'][0]) : null;

// Insert into students table
$sql = "INSERT INTO `students` (user_id, `firstname`, `lastname`, `birthdate`, `present_address`, `course`, `civil`, `batch`, `qrimage`, `major_id`, `alumni_status`) 
        VALUES (:user_id, :firstname, :lastname, :birthdate, :present_address, :course, :civil, :batch, :qrimage, :major_id, 'active')";
$stmt = $db->prepare($sql);
$stmt->bindParam(':user_id', $user_id);
$stmt->bindParam(':firstname', $firstname);
$stmt->bindParam(':lastname', $lastname);
$stmt->bindParam(':birthdate', $birthdate);
$stmt->bindParam(':present_address', $present_address);
$stmt->bindParam(':course', $course);
$stmt->bindParam(':civil', $civil);
$stmt->bindParam(':batch', $batch);
$stmt->bindParam(':qrimage', $qrcode);
$stmt->bindParam(':major_id', $major_id);

if ($stmt->execute()) {
    header('Location: ../../administrator/gallery.php?type=success&message=' . urlencode('Successfully Registered.'));
    exit;
} else {
    $errorInfo = $stmt->errorInfo();
    echo "Error inserting student: " . $errorInfo[2];
    exit;
}

// Close the connection
$db = null;
?>
