<?php
require_once '../functions/conn.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['student_id'])) {
        $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
        $courseid = mysqli_real_escape_string($conn, $_POST['courseid']);
        $batchid = mysqli_real_escape_string($conn, $_POST['batchid']);

        // SQL to delete the student
        $sql = "DELETE FROM alumnigallery WHERE ID = '$student_id'";

        if (mysqli_query($conn, $sql)) {
            // Redirect with success message
            header("Location: gallery.php?course=$courseid&batch=$batchid&stat=success");
            $_SESSION['stat'] = "success";
            $_SESSION['msg'] = "Student deleted successfully.";
            exit();
        } else {
            // Redirect with error message
            header("Location: gallery.php?course=$courseid&batch=$batchid&stat=error");
            $_SESSION['stat'] = "error";
            $_SESSION['msg'] = "Failed to delete student.";
            exit();
        }
    }
} else {
    // Redirect if accessed directly
    header("Location: gallery.php?course=$courseid&batch=$batchid&stat=error");
    exit();
}
