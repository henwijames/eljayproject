<?php
// process_qr.php

// Check if 'qr_code' is present in the GET request
if (isset($_GET['qr_code'])) {
    // Get the QR code content
    $qr_code = htmlspecialchars($_GET['qr_code']);
    
    // Process the QR code data (e.g., save it in a database, log it, etc.)
    echo "Scanned QR Code: " . $qr_code;
    
    // Example of saving QR code to a database (optional):
    /*
    $conn = new mysqli('localhost', 'username', 'password', 'database');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    $stmt = $conn->prepare("INSERT INTO qr_codes (code) VALUES (?)");
    $stmt->bind_param('s', $qr_code);
    $stmt->execute();
    $stmt->close();
    $conn->close();
    
    echo "QR code saved successfully!";
    */
} else {
    echo "No QR code data found.";
}
?>
