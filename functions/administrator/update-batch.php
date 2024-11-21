<?php
require_once '../conn.php';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Check if the form is submitted and required fields are present
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id']) && isset($_POST['year'])) {
        
        // Sanitize and retrieve the form inputs
        $id = intval($_POST['id']); // Convert id to integer to prevent SQL injection
        $year = mysqli_real_escape_string($conn, trim($_POST['year']));

        // Debugging: Check if form data is being received
        if (empty($id) || empty($year)) {
            echo "ID or Year is missing.";
            exit();
        }

        // Debugging: Output to see if the values are correct
        echo "ID: $id, Year: $year";

        // Prepare the SQL statement to update the batch
        $query = "UPDATE batch SET year = ? WHERE id = ?";

        // Initialize prepared statement
        if ($stmt = mysqli_prepare($conn, $query)) {
            // Bind parameters to the SQL query
            mysqli_stmt_bind_param($stmt, 'si', $year, $id);
            
            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                // Success: Redirect to a success page or show a success message
                header("Location: ../../administrator/batch.php?type=success&message=Successfully Updated'");
                exit();
            } else {
                // Failure: Print error message
                echo "Failed to update the batch.";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            // If preparation of the statement fails
            echo "Failed to prepare the SQL statement.";
        }

        // Close the database connection
        mysqli_close($conn);
    } else {
        // If the form is not submitted correctly
        echo "Form not submitted or required fields are missing.";
    }
} catch (Exception $e) {
    // Catch any errors and print them
    echo "Error: " . $e->getMessage();
    exit();
}
?>