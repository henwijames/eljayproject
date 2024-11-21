<?php
include_once '../connection.php';
ob_start();

if (isset($_POST['student_id'])) {
    try {
        $student_id = filter_var($_POST['student_id'], FILTER_VALIDATE_INT);

        // Check if student ID is valid
        if ($student_id === false) {
            throw new Exception("Invalid Student ID.");
        }

        $stmt = $db->prepare("SELECT * FROM students WHERE id = ?");
        $stmt->execute([$student_id]);
        $result = $stmt->fetch();

        if (!$result) {
            http_response_code(400);
            exit("Invalid Student ID.");
        }

        // Prepare fields to be updated
        $fieldsToUpdate = [];
        $params = [];

        // Process achievement ID if provided
        if (!empty($_POST['achievement_id'])) {
            $achievement_id = filter_var($_POST['achievement_id'], FILTER_VALIDATE_INT);
            if ($achievement_id !== false) {
                $fieldsToUpdate[] = "achievement_id = ?";
                $params[] = $achievement_id;
            }
        }

        // Process motto if provided
        if (isset($_POST['motto'])) { // Adjusted to allow empty mottos as well
            $motto = filter_var($_POST['motto'], FILTER_SANITIZE_STRING);
            $fieldsToUpdate[] = "motto = ?";
            $params[] = $motto;
        }

        // Process profile picture if provided and valid
        if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['error'] === 0) {
            $fileTmpPath = $_FILES['profile_pic']['tmp_name'];
            $fileName = basename($_FILES['profile_pic']['name']);
            $fileType = $_FILES['profile_pic']['type'];
            $fileSize = $_FILES['profile_pic']['size'];

            // Allowed file types and max size 
            $allowedFileTypes = ['image/jpeg', 'image/png', 'image/gif'];
            $maxFileSize = 2 * 1024 * 1024; // 2 MB

            if (in_array($fileType, $allowedFileTypes) && $fileSize <= $maxFileSize) {
                $newFileName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9-_\.]/', '_', $fileName);
                $uploadFileDir = '../../student/images/';
                $dest_path = $uploadFileDir . $newFileName;

                if (move_uploaded_file($fileTmpPath, $dest_path)) {
                    $fieldsToUpdate[] = "profile_pic = ?";
                    $params[] = $newFileName;
                } else {
                    header('Location: ../../administrator/gallery.php?type=error&message=Error moving uploaded file.');
                    exit;
                }
            } else {
                header('Location: ../../administrator/gallery.php?type=error&message=Allowed types: jpg, png, gif. Max size: 2MB.');
                exit;
            }
        }

        // If there are fields to update, execute the update statement
        if (!empty($fieldsToUpdate)) {
            $params[] = $student_id; // Add student_id for the WHERE clause
            $query = "UPDATE students SET " . implode(", ", $fieldsToUpdate) . ", status = 'active' WHERE id = ?";
            $stmt = $db->prepare($query);

            if ($stmt->execute($params)) {
                ob_clean();
                header('Location: ../../administrator/gallery.php?type=success&message=Update Successful');
                exit;
            } else {
                echo "Error updating data: " . implode(":", $stmt->errorInfo());
            }
        } else {
            header('Location: ../../administrator/gallery.php?type=error&message=No fields provided for update.');
        }
    } catch (Exception $e) {
        error_log("Error: " . $e->getMessage());
        echo "An error occurred. Please try again.";
    }
} else {
    http_response_code(400);
    echo "Invalid request method.";
}

// Close the database connection
if (isset($db)) {
    $db = null;
}
ob_end_flush();
?>
