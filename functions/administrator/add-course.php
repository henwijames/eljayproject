<?php
require_once '../connection.php';

$name = $_POST['name'];
$majors = $_POST['majors']; // Array of majors

try {
    // Start a transaction
    $db->beginTransaction();
    
    // Insert course
    $sql = 'INSERT INTO `courses` (`name`) VALUES (:name)';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':name', $name);
    $stmt->execute();
    
    // Get the last inserted course ID
    $course_id = $db->lastInsertId();
    
    // Prepare insert statement for majors
    $sql = 'INSERT INTO `majors` (`course_id`, `major_name`) VALUES (:course_id, :major_name)';
    $stmt = $db->prepare($sql);

    // Insert each major
    foreach ($majors as $major_name) {
        $stmt->bindParam(':course_id', $course_id);
        $stmt->bindParam(':major_name', $major_name);
        $stmt->execute();
    }
    
    // Commit the transaction
    $db->commit();
    
    header('Location: ../../administrator/course.php?type=success&message=Successfully Added');
} catch (Exception $e) {
    // Rollback the transaction if something fails
    $db->rollBack();
    
    // Redirect with error message
    header('Location: ../../administrator/course.php?type=error&message=' . urlencode('Failed to add course: ' . $e->getMessage()));
}
?>
