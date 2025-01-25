<?php
    include '../../render/connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Check if the form input is valid
        if (isset($_POST['add_product_category_input']) && !empty($_POST['add_product_category_input'])) {
            $category = $_POST['add_product_category_input'];

            // Use prepared statements to avoid SQL injection
            $sql = "INSERT INTO product_category (category) VALUES (?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("s", $category);
                if ($stmt->execute()) {
                    // Redirect to inventory.php using JavaScript
                    $redirectUrl = "../../admin/web_content/inventory.php";
                    echo '<script type="text/javascript">';
                    echo 'window.location.href = "' . $redirectUrl . '";';
                    echo '</script>';
                    exit();
                } else {
                    echo "Error inserting category: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $conn->error;
            }
        } else {
            echo "Category input cannot be empty.";
        }
    } else {
        echo "Invalid request method.";
    }

    // Close the database connection
    $conn->close();
?>