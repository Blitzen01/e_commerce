<?php
session_start();
include "../../render/connection.php";

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: sign_in.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stock = intval($_GET['quantity']);
}

$email = $_SESSION['email'];
$user_id = "";

// Fetch user ID using prepared statement
$sqlUser = "SELECT id FROM user_account WHERE email = ?";
$stmtUser = $conn->prepare($sqlUser);
$stmtUser->bind_param("s", $email);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows > 0) {
    $row = $resultUser->fetch_assoc();
    $user_id = $row['id'];
} else {
    echo "User not found.";
    exit;
}

$stmtUser->close();

// Get the billing address ID from the form
$billing_address_id = $_POST['billing_address'] ?? null;

if ($billing_address_id) {
    // Begin transaction to update billing addresses
    $conn->begin_transaction();

    try {
        // Unset all existing default addresses
        $sqlUnsetDefault = "UPDATE billing_address SET default_address = 0 WHERE user_id = ?";
        $stmtUnsetDefault = $conn->prepare($sqlUnsetDefault);
        $stmtUnsetDefault->bind_param("i", $user_id);
        $stmtUnsetDefault->execute();
        $stmtUnsetDefault->close();

        // Set the selected billing address as default
        $sqlSetDefault = "UPDATE billing_address SET default_address = 1 WHERE id = ? AND user_id = ?";
        $stmtSetDefault = $conn->prepare($sqlSetDefault);
        $stmtSetDefault->bind_param("ii", $billing_address_id, $user_id);
        $stmtSetDefault->execute();
        $stmtSetDefault->close();

        // Fetch the default billing address details to update user_account
        $sqlGetDefaultAddress = "SELECT full_name, address, contact_number FROM billing_address WHERE id = ? AND user_id = ? AND default_address = 1";
        $stmtGetDefault = $conn->prepare($sqlGetDefaultAddress);
        $stmtGetDefault->bind_param("ii", $billing_address_id, $user_id);
        $stmtGetDefault->execute();
        $resultAddress = $stmtGetDefault->get_result();

        if ($resultAddress->num_rows > 0) {
            $rowAddress = $resultAddress->fetch_assoc();
            $full_name = $rowAddress['full_name'];
            $default_address = $rowAddress['address'];
            $contact_number = $rowAddress['contact_number'];

            // Update user_account table to reflect the default address and contact info
            $sqlUpdateUserAccount = "UPDATE user_account SET full_name = ?, address = ?, contact_number = ? WHERE id = ?";
            $stmtUpdateUserAccount = $conn->prepare($sqlUpdateUserAccount);
            $stmtUpdateUserAccount->bind_param("sssi", $full_name, $default_address, $contact_number, $user_id);
            $stmtUpdateUserAccount->execute();
            $stmtUpdateUserAccount->close();
        } else {
            throw new Exception("Failed to fetch the default address.");
        }

        $stmtGetDefault->close();

        // Commit the transaction
        $conn->commit();

        $redirectUrl = "../../user/confirm_package_purchase.php?id=$id&quantity=$stock";
        // Redirect back to the user profile page
        echo '<script type="text/javascript">';
        echo 'window.location.href = "' . $redirectUrl . '";';
        echo '</script>';
    } catch (Exception $e) {
        // Rollback the transaction on error
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No billing address selected.']);
}

$conn->close();
?>
