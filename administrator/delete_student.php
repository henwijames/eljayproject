<?php
require_once '../functions/conn.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['student_id'])) {
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

        // SQL to delete the student
        $sql = "DELETE FROM students WHERE id = '$student_id'";

        if (mysqli_query($conn, $sql)) {
            // Redirect with success message
            header("Location: gallery.php?msg=deleted"); // Adjust to your page
            exit();
        } else {
            // Redirect with error message
            header("Location: gallery.php?msg=error");
            exit();
        }
    }
} else {
    // Redirect if accessed directly
    header("Location: gallery.php");
    exit();
}
