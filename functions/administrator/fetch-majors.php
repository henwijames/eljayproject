<?php
require_once '../connection.php';

// Check if 'course_id' is provided in the GET request
if (isset($_GET['course_id'])) {
    $course_id = $_GET['course_id'];

    // Prepare and execute the query
    $sql = 'SELECT `name` FROM `majors` WHERE `course_id` = :course_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':course_id', $course_id);
    $stmt->execute();

    // Fetch all majors
    $majors = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the majors as JSON
    echo json_encode($majors);
} else {
    // Return an empty array if 'course_id' is not provided
    echo json_encode([]);
}
?>
