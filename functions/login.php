<?php
require_once 'connection.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Initialize variables to prevent undefined index notices
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Prepare SQL query to prevent SQL injection
$sql = "SELECT * FROM users WHERE username = ? AND status = 'approved'";
$stmt = $db->prepare($sql);
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    // Verify password and handle success or failure
    if (password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $user['id'];
        $_SESSION['type'] = $user['type'];

        // Redirect based on user type
        switch ($user['type']) {
            case 'student':
                header('Location: ../student/');
                exit;
            case 'administrator':
                header('Location: ../administrator/');
                exit;
            default:
                $_SESSION['error'] = 'Unexpected user type.';
                header('Location: ../index.php');
                exit;
        }
    } else {
        $_SESSION['error'] = 'Invalid Username or Password - Your account may still be pending.';
        header('Location: ../index.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'Invalid Username or Password - Your account may still be pending.';
    header('Location: ../index.php');
    exit;
}
?>
