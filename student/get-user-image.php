<?php
session_start();

if (!isset($_SESSION['username'])) {
    header('HTTP/1.1 403 Forbidden');
    exit;
}

try {
    $pdo = new PDO('mysql:host=localhost;dbname=lc', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("
        SELECT profile_pic 
        FROM students s
        JOIN users u ON s.user_id = u.id
        WHERE u.username = :username
    ");
    $stmt->execute(['username' => $_SESSION['username']]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student || empty($student['profile_pic'])) {
        header('HTTP/1.1 404 Not Found');
        exit;
    }

    $filePath = $student['profile_pic'];

    if (!file_exists($filePath)) {
        header('HTTP/1.1 404 Not Found');
        exit;
    }

    header('Content-Type: image/png');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);

} catch (PDOException $e) {
    header('HTTP/1.1 500 Internal Server Error');
    exit;
}
?>
