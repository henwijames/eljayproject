<?php
// Database connection details
$db_host = 'localhost';
$db_name = 'lc';
$db_user = 'root';
$db_pass = '';

// Create PDO connection
try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure uploads directory exists
    if (!file_exists('../../student/images/')) {
        mkdir('../../student/images/', 0777, true);
    }

    // Collect and sanitize form inputs
    $student_id = isset($_POST['student_id']) ? $_POST['student_id'] : null;
    $firstname = isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : null;
    $lastname = isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : null;
    $birthdate = isset($_POST['birthdate']) ? $_POST['birthdate'] : null;
    $present_address = isset($_POST['present_address']) ? htmlspecialchars($_POST['present_address']) : null;
    $motto = isset($_POST['motto']) ? htmlspecialchars($_POST['motto']) : null;
    $achievement_id = isset($_POST['achievement_id']) ? $_POST['achievement_id'] : null;
    $course = isset($_POST['course']) ? $_POST['course'] : null;
    $civil = isset($_POST['civil']) ? $_POST['civil'] : null;
    $batch = isset($_POST['batch']) ? $_POST['batch'] : null;
    $profile_pic = null;

    // Handle file upload (only if file is provided)
    if (!empty($_FILES['profile_pic']['name'])) {
        if ($_FILES['profile_pic']['error'] === UPLOAD_ERR_OK) {
            $fileName = $_FILES['profile_pic']['name'];
            $fileTmpName = $_FILES['profile_pic']['tmp_name'];
            $filePath = "../../student/images/" . basename($fileName);

            // Validate file type (JPG, PNG, GIF)
            $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];
            $file_extension = pathinfo($fileName, PATHINFO_EXTENSION);
            if (!in_array(strtolower($file_extension), $allowed_extensions)) {
                die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
            }

            if (move_uploaded_file($fileTmpName, $filePath)) {
                $profile_pic = $fileName; // Successfully uploaded file
            } else {
                die("Failed to move uploaded file.");
            }
        } else {
            die("File upload error: " . $_FILES['profile_pic']['error']);
        }
    }

    // Ensure student_id is set
    if (empty($student_id) || !is_numeric($student_id)) {
        die('Invalid or missing student ID.');
    }

    // Check if achievement_id exists in achievements table
    if (!empty($achievement_id)) {
        $checkAchievement = $pdo->prepare("SELECT id FROM achievements WHERE id = :achievement_id");
        $checkAchievement->bindParam(':achievement_id', $achievement_id);
        $checkAchievement->execute();

        if ($checkAchievement->rowCount() == 0) {
            die('Invalid achievement ID. The specified achievement does not exist.');
        }
    }

    // Update the database
    try {
        $sql = "UPDATE students SET 
                    firstname = :firstname,
                    lastname = :lastname,
                    birthdate = :birthdate,
                    present_address = :present_address,
                    motto = :motto,
                    achievement_id = :achievement_id,
                    course = :course,
                    civil = :civil,
                    batch = :batch,
                    profile_pic = COALESCE(:profile_pic, profile_pic)
                WHERE id = :id";

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':firstname', $firstname ?: null, PDO::PARAM_STR);
        $stmt->bindValue(':lastname', $lastname ?: null, PDO::PARAM_STR);
        $stmt->bindValue(':birthdate', $birthdate ?: null, PDO::PARAM_STR);
        $stmt->bindValue(':present_address', $present_address ?: null, PDO::PARAM_STR);
        $stmt->bindValue(':motto', $motto ?: null, PDO::PARAM_STR);
        $stmt->bindValue(':achievement_id', $achievement_id ?: null, PDO::PARAM_INT);
        $stmt->bindValue(':course', $course ?: null, PDO::PARAM_INT);
        $stmt->bindValue(':civil', $civil ?: null, PDO::PARAM_STR);
        $stmt->bindValue(':batch', $batch ?: null, PDO::PARAM_INT);
        $stmt->bindValue(':profile_pic', $profile_pic ?: null, PDO::PARAM_STR);
        $stmt->bindParam(':id', $student_id);

        if ($stmt->execute()) {
            header('Location: ../../administrator/gallery.php?type=success&message=' . urlencode('Successfully Updated - Your profile has been updated.'));
            exit();
        } else {
            $errorInfo = $stmt->errorInfo();
            echo "Failed to update the student. SQL Error: " . $errorInfo[2];
        }
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
    }
}
?>
