<?php

require_once '../connection.php';

// PHPMailer namespace imports
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/SMTP.php';

// Check if the required POST data exists
if (isset($_POST['user_id']) && isset($_POST['email'])) {
    $user_id = $_POST['user_id'];
    $email = $_POST['email'];

    // DEBUG: Print user_id to check its value
    echo 'User ID: ' . $user_id . '<br>';
    echo 'Email: ' . $email . '<br>';

    try {
        // Force update only if status is not already 'approved'
        $sql = "UPDATE users SET status = 'approved' WHERE id = :user_id AND status != 'approved'";
        $stmt = $db->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);

        // DEBUG: Check if the query affected any rows
        $rowCount = $stmt->rowCount();
        echo 'Rows affected: ' . $rowCount . '<br>';

        // If the update was successful, send the email
        if ($rowCount > 0) {
            // Send email logic here
            $mail = new PHPMailer(true);

            try {
                // Server settings for PHPMailer
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
                $mail->SMTPAuth = true;
                $mail->Username = 'egopbayton@gmail.com'; // Your email
                $mail->Password = 'dmaf tjfi wgxj xotz'; // Your email password
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Set the sender and recipient
                $mail->setFrom('egopbayton@gmail.com', 'Lemery Colleges');
                $mail->addAddress($email); // The student's email

                // Set email format and content
                $mail->isHTML(true);
                $mail->Subject = 'Your Registration Has Been Approved';
                $mail->Body    = '<h1>Congratulations!</h1>
                                <p>Your registration has been approved. You can now access your account by clicking 
                                <a href="https://www.youtube.com/" target="_blank">here</a>.</p>';
                $mail->AltBody = 'Your registration has been approved. Visit to access your account.';

                // Send the email
                $mail->send();
                echo 'Approval email has been sent successfully.';
                header('Location: ../../administrator/alumni-pending.php?type=success&message=Emails have been sent successfully.');
            } catch (Exception $e) {
                echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
                header('Location: ../../administrator/alumni-pending.php?type=error&message=Email could not be sent. Mailer Error:');
            }
        } else {
            echo 'User status update failed.';
            header('Location: ../../administrator/alumni-pending.php?type=error&message=Couldnt find your email.');
        }
    } catch (PDOException $e) {
        // Handle any database-related errors
        echo 'Database error: ' . $e->getMessage();
        header('Location: ../../administrator/alumni-pending.php?type=error&message=Database error.');
    }
} else {
    echo 'Invalid request. Missing user ID or email.';
    header('Location: ../../administrator/alumni-pending.php?type=error&message=Invalid request. Missing user ID or email.');
}
