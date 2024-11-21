<?php
// Define database connection parameters
$host = 'localhost'; // Database host (localhost for local development)
$dbname = 'lc'; // The name of your database
$username = 'root'; // Your database username
$password = ''; // Your database password (empty for default local setup)

// Set up the DSN (Data Source Name)
$dsn = "mysql:host=$host;dbname=$dbname;charset=utf8";

try {
    // Create a PDO instance (connect to the database)
    $db = new PDO($dsn, $username, $password);

    // Set error mode to exception to handle errors
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Optional: Set the default fetch mode to associative array
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    echo "Connection successful!";
} catch (PDOException $e) {
    // If there is an error, it will be caught here
    echo "Connection failed: " . $e->getMessage();
}
?>
