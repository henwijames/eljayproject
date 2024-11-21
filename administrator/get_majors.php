<?php
include_once '../functions/connection.php';

if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);

    $query = "SELECT id, name FROM majors WHERE course_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$course_id]);
    $majors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($majors) {
        echo json_encode(['status' => 'success', 'majors' => $majors]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No majors found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid course ID.']);
}
?>
