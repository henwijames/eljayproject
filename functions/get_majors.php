<?php
include_once 'connection.php';

header('Content-Type: application/json');

// Check if course ID is provided in the request
if (isset($_GET['course_id'])) {
    $course_id = intval($_GET['course_id']);
    
    // Fetch majors associated with the given course ID
    $sql = "SELECT id, major_name FROM majors WHERE course_id = :course_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);

    if ($stmt->execute()) {
        $majors = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return the majors as a JSON response
        echo json_encode([
            'status' => 'success',
            'majors' => $majors
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to fetch majors.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'No course ID provided.'
    ]);
}

// Close the connection
$db = null;
?>
