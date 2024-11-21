<?php
require_once '../connection.php';

// Check if 'id' is set and validate it
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $id = filter_var($_POST['id'], FILTER_VALIDATE_INT);

    if ($id !== false) {
        try {
            // Prepare SQL statement to delete the batch
            $sql = 'DELETE FROM `achievements` WHERE `id` = :id';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            // Execute the statement
            $result = $stmt->execute();
            
            // Check if any rows were affected
            if ($result && $stmt->rowCount() > 0) {
                // Redirect with success message
                header('Location: ../../administrator/batch.php?type=success&message=' . urlencode('Successfully Deleted'));
                exit();
            } else {
                // If no rows were affected, redirect with an error
                header('Location: ../../administrator/batch.php?type=error&message=' . urlencode('No Record Found or Deletion Failed'));
                exit();
            }
        } catch (PDOException $e) {
            // Catch any database errors
            header('Location: ../../administrator/batch.php?type=error&message=' . urlencode('Error: ' . $e->getMessage()));
            exit();
        }
    } else {
        // If the ID is not valid, redirect with an error message
        header('Location: ../../administrator/batch.php?type=error&message=' . urlencode('Invalid Batch ID'));
        exit();
    }
} else {
    // If 'id' is not set, redirect with an error message
    header('Location: ../../administrator/batch.php?type=error&message=' . urlencode('Batch ID Not Provided'));
    exit();
}
