<?php
session_start();
require "../../render/connection.php";
require "../../vendor/autoload.php"; // Include PHPMailer via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['full_name']);
    $user_email = trim($_POST['user_email']);
    $user_password = trim($_POST['user_password']);
    $user_confirm_password = trim($_POST['user_confirm_password']);

    // Check if passwords match
    if ($user_password !== $user_confirm_password) {
        die("Passwords do not match.");
    }

    // Hash the password
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Split full name into components
    $name_parts = explode(" ", $full_name);
    $first_name = $name_parts[0];
    $last_name = end($name_parts);
    $middle_name = count($name_parts) > 2 ? implode(" ", array_slice($name_parts, 1, -1)) : '';

    // Generate a unique token
    $token = bin2hex(random_bytes(15));

    // Insert user data into the database with 'pending' status
    $stmt = $conn->prepare("
        INSERT INTO user_account (full_name, first_name, last_name, middle_name, email, password, token, status, is_new)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'pending', 0)
    ");
    $stmt->bind_param("sssssss", $full_name, $first_name, $last_name, $middle_name, $user_email, $hashed_password, $token);

    if ($stmt->execute()) {
        // Generate verification link
        $verification_link = "http://localhost/e_commerce/asstes/php_script/verify.php?token=$token";

        // Send verification email using PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Use your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'hfacomputerpartsrepairservices@gmail.com'; // Your Gmail address
            $mail->Password = 'hfa012019'; // Your Gmail App Password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('hfacomputerpartsrepairservices', 'HFA Computer Parts and Repair Services');
            $mail->addAddress($user_email, $full_name);

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Email Verification";
            $mail->Body = "Hello $full_name,<br><br>Please verify your email by clicking the link below:<br>
                <a href='$verification_link'>$verification_link</a><br><br>Thank you!";

            $mail->send();
            echo "Verification email sent. Please check your inbox.";
        } catch (Exception $e) {
            echo "Failed to send verification email. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
