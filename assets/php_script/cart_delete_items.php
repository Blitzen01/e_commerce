<?php
// Start session and include database connection
session_start();
include "../../render/connection.php";

// Check if delete_ids is set
if (isset($_POST['delete_ids'])) {
    // Decode the JSON array of IDs
    $deleteIds = json_decode($_POST['delete_ids'], true);

    // Prepare and execute the deletion query
    if (!empty($deleteIds)) {
        $placeholders = implode(',', array_fill(0, count($deleteIds), '?'));
        $sql = "DELETE FROM product_cart WHERE id IN ($placeholders)";
        $stmt = $conn->prepare($sql);

        // Bind the IDs dynamically
        $types = str_repeat('i', count($deleteIds)); // Assuming all IDs are integers
        $stmt->bind_param($types, ...$deleteIds);

        // Execute the query
        if ($stmt->execute()) {
            // Success message or redirect
            $redirectUrl = "../../user/cart.php";
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            echo "Error deleting items: " . $stmt->error;
        }

        $stmt->close();
    }
}

// Close the database connection
$conn->close();
?>
