<?php
header('Content-Type: application/json'); // Ensure the response is JSON
require_once '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if studentId is provided
    $data = json_decode(file_get_contents('php://input'), true);
    $studentId = $data['studentId'] ?? null;

    if ($studentId) {
        // Assuming you have a valid database connection $db
        $stmt = $db->prepare("DELETE FROM students WHERE id = ?");
        $stmt->execute([$studentId]);

        // Check if deletion was successful
        if ($stmt->rowCount() > 0) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Student not found']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No student ID provided']);
    }
}
?>
