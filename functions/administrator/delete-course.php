<?php
require_once '../connection.php';

// Ensure the 'id' parameter is set and valid
if (!isset($_POST['id']) || empty($_POST['id'])) {
    header('Location: ../../administrator/course.php?type=error&message=Invalid ID');
    exit;
}

$id = $_POST['id'];

if (!filter_var($id, FILTER_VALIDATE_INT)) {
    header('Location: ../../administrator/course.php?type=error&message=Invalid ID format');
    exit;
}

try {
    // Start a transaction
    $db->beginTransaction();

    // Delete related records first
    $deleteMajors = 'DELETE FROM `majors` WHERE `course_id` = :id';
    $stmt = $db->prepare($deleteMajors);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Now delete the course
    $deleteCourse = 'DELETE FROM `courses` WHERE `id` = :id';
    $stmt = $db->prepare($deleteCourse);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Commit the transaction
    $db->commit();

    header('Location: ../../administrator/course.php?type=success&message=Successfully Deleted');
} catch (PDOException $e) {
    // Rollback the transaction if something goes wrong
    $db->rollBack();

    // Log the error message for debugging purposes
    error_log("Database error: " . $e->getMessage());

    // Redirect with an error message
    header('Location: ../../administrator/course.php?type=error&message=Failed to delete course');
}

exit;
