<?php
try {
    $pdo = new PDO('mysql:host=localhost;dbname=lc', 'root', '');
    echo "Connected to the database!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
