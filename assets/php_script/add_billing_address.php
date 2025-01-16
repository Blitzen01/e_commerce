<?php
// Start session and include database connection
session_start();
include "../../render/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $fullName = $_POST['full_name'];
    $address = $_POST['address'];
    $contactNumber = $_POST['contact_number'];
    $defaultAddress = isset($_POST['default_address']) ? 1 : 0;

    // Get the user's email from the session
    $email = $_SESSION['email']; // Assuming email is stored in the session

    if (!$email) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    try {
        // Fetch user_id from user_account table
        $sqlUserId = "SELECT id FROM user_account WHERE email = ?";
        $stmtUserId = $conn->prepare($sqlUserId);
        $stmtUserId->bind_param("s", $email);
        $stmtUserId->execute();
        $stmtUserId->bind_result($userId);
        $stmtUserId->fetch();
        $stmtUserId->close();

        if (!$userId) {
            throw new Exception("User not found.");
        }

        // Begin transaction
        $conn->begin_transaction();

        if ($defaultAddress) {
            // Update all other addresses for the user to not default
            $updateSql = "UPDATE billing_address SET default_address = 0 WHERE user_id = ?";
            $stmtUpdate = $conn->prepare($updateSql);
            $stmtUpdate->bind_param("i", $userId);
            $stmtUpdate->execute();
            $stmtUpdate->close();
        }

        // Insert the new billing address
        $insertSql = "INSERT INTO billing_address (user_id, full_name, address, contact_number, default_address) 
                      VALUES (?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($insertSql);
        $stmtInsert->bind_param("isssi", $userId, $fullName, $address, $contactNumber, $defaultAddress);

        if ($stmtInsert->execute()) {
            // If the address is set as default, update the user_account with the new address
            if ($defaultAddress) {
                $updateUserAccountSql = "UPDATE user_account 
                                         SET full_name = ?, address = ?, contact_number = ? 
                                         WHERE id = ?";
                $stmtUpdateUserAccount = $conn->prepare($updateUserAccountSql);
                $stmtUpdateUserAccount->bind_param("sssi", $fullName, $address, $contactNumber, $userId);
                $stmtUpdateUserAccount->execute();
                $stmtUpdateUserAccount->close();
            }

            // Commit transaction
            $conn->commit();
            $redirectUrl = "../../user/cart.php";
            // Redirect back to the user profile page
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            throw new Exception("Failed to add billing address.");
        }

        $stmtInsert->close();
    } catch (Exception $e) {
        // Rollback transaction on error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }

    $conn->close();
}
?>
