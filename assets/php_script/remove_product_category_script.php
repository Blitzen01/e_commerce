<?php
    include '../../render/connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the selected category is set and not empty
        if (isset($_POST['remove_product_category_selected']) && !empty($_POST['remove_product_category_selected'])) {
            $categoryToRemove = $_POST['remove_product_category_selected'];

            // Use a prepared statement to avoid SQL injection
            $sql = "DELETE FROM product_category WHERE category = ?";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $categoryToRemove);
                if ($stmt->execute()) {
                    // Redirect back to the inventory page after removal
                    $redirectUrl = "../../admin/web_content/inventory.php";
                    echo '<script type="text/javascript">';
                    echo 'window.location.href = "' . $redirectUrl . '";';
                    echo '</script>';
                    exit();
                } else {
                    echo "Error removing category: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Please select a category to remove.";
        }
    } else {
        echo "Invalid request method.";
    }

    // Close the database connection
    $conn->close();
?>
