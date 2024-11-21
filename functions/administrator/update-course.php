<?php
require_once '../connection.php';

$id = $_POST['id'];
$name = $_POST['name'];
$majors = $_POST['majors']; // Array of majors from the form

try {
    // Begin transaction
    $db->beginTransaction();

    // Update course name
    $sql = 'UPDATE `courses` SET `name` = :name WHERE `id` = :id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->bindParam(':name', $name);
    $stmt->execute();

    // Delete existing majors for the course
    $sql = 'DELETE FROM `majors` WHERE `course_id` = :course_id';
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':course_id', $id);
    $stmt->execute();

    // Insert new majors
    $sql = 'INSERT INTO `majors` (`course_id`, `name`) VALUES (:course_id, :name)';
    $stmt = $db->prepare($sql);
    
    foreach ($majors as $major) {
        $stmt->bindParam(':course_id', $id);
        $stmt->bindParam(':name', $major);
        $stmt->execute();
    }

    // Commit transaction
    $db->commit();

    header('Location: ../../administrator/course.php?type=success&message=Successfully Updated');
} catch (Exception $e) {
    // Rollback transaction on error
    $db->rollBack();
    error_log($e->getMessage());
    header('Location: ../../administrator/course.php?type=error&message=' . urlencode('Failed to update course: ' . $e->getMessage()));
}
?>
