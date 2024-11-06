<?php
    include '../../render/connection.php';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $product_id = $_POST['product_id'];
        $product_category = $_POST['product_category'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_stocks = $_POST['product_stocks'];

        // Update data in the products table
        $sql = "UPDATE products SET category = '$product_category', product_name = '$product_name', price = '$product_price', stocks = '$product_stocks' WHERE id = '$product_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../admin/web_content/inventory.php";
            // Redirect back to the inventory page
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message
            echo "Error updating product: " . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    }
?>
