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

    // Begin transaction
    $conn->begin_transaction();

    try {
        // Update user details in the user_account table
        $sqlUpdate = "UPDATE user_account SET password = ?, address = ?, contact_number = ?, is_new = ? WHERE email = ?";
        $stmtUpdate = $conn->prepare($sqlUpdate);
        $stmtUpdate->bind_param("sssis", $hashedPassword, $address, $contactNumber, $isNew, $email);

        if (!$stmtUpdate->execute()) {
            throw new Exception("Failed to update user account.");
        }

        // Get the user_id and full_name for the current email
        $sqlUserDetails = "SELECT id, full_name FROM user_account WHERE email = ?";
        $stmtUserDetails = $conn->prepare($sqlUserDetails);
        $stmtUserDetails->bind_param("s", $email);
        $stmtUserDetails->execute();
        $stmtUserDetails->bind_result($userId, $fullName);
        $stmtUserDetails->fetch();
        $stmtUserDetails->close();

        if (!$userId || empty($fullName)) {
            throw new Exception("User details not found.");
        }

        // Insert data into billing_address table and set as default
        $sqlBilling = "INSERT INTO billing_address (user_id, full_name, address, contact_number, default_address) 
                       VALUES (?, ?, ?, ?, 1)";
        $stmtBilling = $conn->prepare($sqlBilling);
        $stmtBilling->bind_param("isss", $userId, $fullName, $address, $contactNumber);

        if (!$stmtBilling->execute()) {
            throw new Exception("Failed to insert billing address.");
        }

        // Commit the transaction
        $conn->commit();

        // Redirect to the user dashboard
        $redirectUrl = "../../user/index.php";
        echo '<script type="text/javascript">';
        echo 'window.location.href = "' . $redirectUrl . '";';
        echo '</script>';
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    // Close connections
    $stmtUpdate->close();
    $stmtBilling->close();
    $conn->close();
    exit;
}
?>
