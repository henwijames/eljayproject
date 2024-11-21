<?php
include_once '../connection.php';

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    error_log('Invalid Request Method');
    header('Location: ../../administrator/alumni.php?type=error&message=Invalid Request Method');
    exit;
}

if (!isset($_POST['id']) || empty($_POST['id'])) {
    error_log('No ID Provided');
    header('Location: ../../administrator/alumni.php?type=error&message=No ID Provided');
    exit;
}

$id = $_POST['id'];
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$firstname = $_POST['firstname'] ?? '';
$lastname = $_POST['lastname'] ?? '';
$birthdate = $_POST['birthdate'] ?? '';
$email = $_POST['email'] ?? '';
$course = $_POST['course'] ?? '';
$civil = $_POST['civil'] ?? '';
$phone = $_POST['phone'] ?? '';
$present_address = $_POST['present_address'] ?? '';
$batch = $_POST['batch'] ?? '';

$profile_pic = '';
if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
    $fileName = $_FILES['profile_pic']['name'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
    if (in_array($fileExtension, $allowedExtensions)) {
        $uploadFileDir = 'images/';
        $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
        $dest_path = $uploadFileDir . $newFileName;

        if (move_uploaded_file($fileTmpPath, $dest_path)) {
            $profile_pic = $newFileName;
        } else {
            error_log("Failed to move uploaded file.");
            header('Location: ../../administrator/alumni.php?type=error&message=Error Uploading File');
            exit;
        }
    } else {
        error_log("Invalid File Extension");
        header('Location: ../../administrator/alumni.php?type=error&message=Invalid File Extension');
        exit;
    }
}

try {
    $db->beginTransaction();

    $sql = "UPDATE `users` SET `username` = :username, `password` = :password WHERE `id` = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $sql = "UPDATE `students` SET 
            `firstname` = :firstname, 
            `lastname` = :lastname, 
            `birthdate` = :birthdate, 
            `email` = :email, 
            `course` = :course, 
            `civil` = :civil, 
            `phone` = :phone, 
            `present_address` = :present_address, 
            `batch` = :batch, 
            `profile_pic` = :profile_pic
            WHERE `user_id` = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':firstname', $firstname);
    $stmt->bindParam(':lastname', $lastname);
    $stmt->bindParam(':birthdate', $birthdate);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':course', $course, PDO::PARAM_INT);
    $stmt->bindParam(':civil', $civil);
    $stmt->bindParam(':phone', $phone);
    $stmt->bindParam(':present_address', $present_address);
    $stmt->bindParam(':batch', $batch, PDO::PARAM_INT);
    $stmt->bindParam(':profile_pic', $profile_pic);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $db->commit();
    error_log("Transaction committed.");
    header('Location: ../../administrator/alumni.php?type=success&message=Successfully Updated');
    exit;
} catch (Exception $e) {
    $db->rollBack();
    error_log("Exception: " . $e->getMessage());
    header('Location: ../../administrator/alumni.php?type=error&message=' . urlencode($e->getMessage()));
    exit;
}
