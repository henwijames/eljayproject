<?php
include_once '../connection.php';

// Check if the 'id' is set
if (!isset($_POST['id'])) {
    header('Location: ../../administrator/alumni-pending.php?type=error&message=' . urlencode('No ID Provided'));
    exit;
}

$id = $_POST['id'];

try {
    // Begin a transaction
    $db->beginTransaction();

    // Delete from students table
    $sql = "DELETE FROM `students` WHERE `user_id` = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Delete from users table
    $sql = "DELETE FROM `users` WHERE `id` = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Commit the transaction
    $db->commit();

    // Redirect to success page
    header('Location: ../../administrator/alumni-pending.php?type=success&message=' . urlencode('Successfully Deleted'));
    exit;
} catch (Exception $e) {
    // Rollback the transaction if something failed
    $db->rollBack();
    header('Location: ../../administrator/alumni-pending.php?type=error&message=' . urlencode($e->getMessage()));
    exit;
}
