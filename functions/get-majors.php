<?php
// Ensure that the database connection file is included
require_once 'conn.php'; // Include your database connection file

// Check if course_id is passed via POST
if (isset($_POST['course_id'])) {
    $course_id = $_POST['course_id'];

    // Prepare the SQL query to select majors for the given course_id
    $query = "SELECT * FROM majors WHERE course_id = ?";
    $stmt = $conn->prepare($query); // Prepare statement
    $stmt->bind_param("i", $course_id); // Bind the course_id as an integer parameter
    $stmt->execute(); // Execute the query
    $result = $stmt->get_result(); // Get the result of the query

    // Check if any majors exist for the given course_id
    if ($result->num_rows > 0) {
        // Output each major as a radio button
        while ($row = $result->fetch_assoc()) {
            echo '<div class="form-check">';
            echo '<input class="form-check-input" type="radio" name="majors" value="' . $row['id'] . '" id="major_' . $row['id'] . '">';
            echo '<label class="form-check-label" for="major_' . $row['id'] . '">' . $row['major_name'] . '</label>';
            echo '</div>';
        }
    } else {
        // No majors found for the course
        echo '<div>No majors available</div>';
    }
} else {
    // Course ID was not passed
    echo 'No course ID received';
}
?>
