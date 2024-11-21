<?php
// Set up the database connection details
$host = 'localhost'; // Database host (usually localhost)
$dbname = 'lc'; // Your database name
$username = 'root'; // Your database username
$password = ''; // Your database password

try {
    // Create a PDO instance to connect to the database
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set the PDO error mode to exception to catch errors
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Get the student ID from the URL parameter
    $studentId = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    if ($studentId > 0) {
        // Prepare SQL to fetch the student's data
        $sql = 'SELECT s.*, c.name AS course_name, b.year AS batch_name 
                FROM `students` s
                LEFT JOIN `courses` c ON s.course = c.id
                LEFT JOIN `batch` b ON s.batch = b.id
                WHERE s.id = :id';

        $stmt = $db->prepare($sql);
        $stmt->bindParam(':id', $studentId, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the student's data
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($student) {
            // Return the student data as JSON
            echo json_encode($student);
        } else {
            // If no student is found, return an error message
            echo json_encode(['error' => 'Student not found']);
        }
    } else {
        // If no valid student ID is passed, return an error
        echo json_encode(['error' => 'Invalid student ID']);
    }

} catch (PDOException $e) {
    // If there is an error in connecting to the database, return the error message
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
?>
