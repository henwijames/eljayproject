<?php
require_once '../functions/conn.php'; 

header('Content-Type: application/json');

// Function to get majors by course ID
function getMajorsByCourseId($courseId) {
    global $conn; // Use the global connection
    $query = "SELECT course_id, major_name FROM majors WHERE course_id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        return []; // Return empty array if statement preparation fails
    }
    
    $stmt->bind_param("i", $courseId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $majors = [];
    while ($row = $result->fetch_assoc()) {
        $majors[] = $row;
    }
    
    return $majors;
}

// Check if course_id is provided
if (isset($_GET['course_id'])) {
    $courseId = $_GET['course_id'];

    // Fetch majors based on course ID
    $majors = getMajorsByCourseId($courseId);

    // Prepare the result array
    $result = [];

    if (!empty($majors)) {
        foreach ($majors as $row) {
            $result[] = [
                'id' => $row['major_id'],
                'name' => $row['major_name']
            ];
        }
    }

    // Return JSON response
    echo json_encode(['majors' => $result]);
} else {
    // Return error if no course ID is provided
    echo json_encode(['error' => 'No course ID received.']);
}
?>