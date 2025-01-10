<?php
// Start session and include database connection
session_start();
include "../../render/connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contact_number'];
    $email = $_POST['email']; // Email passed as hidden input
    $isNew = 1; // Set is_new to 1

    // Validate password confirmation
    if ($password !== $confirmPassword) {
        echo json_encode(['success' => false, 'message' => 'Passwords do not match.']);
        exit;
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Update user details in the database
    $sql = "UPDATE user_account SET password = ?, address = ?, contact_number = ?, is_new = 1, is_new = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssis", $hashedPassword, $address, $contactNumber, $isNew, $email);

    if ($stmt->execute()) {
        $redirectUrl = "../../user/index.php";
        echo '<script type="text/javascript">';
        echo 'window.location.href = "' . $redirectUrl . '";';
        echo '</script>';
    } else {
        // Error response
        echo json_encode(['success' => false, 'message' => 'Failed to update profile. Please try again.']);
    }

    $stmt->close();
    $conn->close();
    exit;
}
?>
