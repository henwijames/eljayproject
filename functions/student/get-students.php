<?php
// Database connection
$host = 'localhost';
$dbname = 'lc';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch students from the database
    $stmt = $pdo->query("
        SELECT s.id, s.firstname, s.lastname, s.profile_pic, b.year AS batch, c.name AS course
        FROM students s
        LEFT JOIN batch b ON s.batch = b.id
        LEFT JOIN courses c ON s.course = c.id
    ");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debug: Output the number of students fetched
    if (empty($students)) {
        echo "No students found.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>