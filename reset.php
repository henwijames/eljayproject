<?php
session_start();
require 'functions/vendor/autoload.php';
// PHPMailer namespace imports
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'functions/conn.php';

if(isset($_POST['reset'])){
    $email = $_POST['email'];

    //find the email if existing
    $sql = "SELECT * FROM students WHERE email = '$email'";
    $result = $conn->query($sql);   
    if(mysqli_num_rows($result) > 0){
        //generate 8 digit character for password 

        $row = $result->fetch_assoc();
        $userid = $row['user_id'];
        $password = substr(str_shuffle('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789') , 0 , 8 );
        $newpassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE users SET password = '$newpassword' WHERE id = $userid";
        $conn->query($sql);

        //send email
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
            $mail->Subject = 'Password Reset';
            $mail->Body    = '<h1>Password Reset</h1>
                            <p>Your new password is: '.$password.'</p>';

            // Send the email
            $mail->send();
            $_SESSION['success'] = true;
            $_SESSION['message'] = 'Password reset successful. Check your email for the new password';
            header('Location: index.php');
        } catch (Exception $e) {
            $_SESSION['status'] = 'error';
            $_SESSION['message'] = 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
            header('Location: index.php');

        }

        
    }else{
        $_SESSION['status'] = 'error';
        $_SESSION['message'] = 'Email not found';
        header('Location: index.php');
    }
    
}
?>