<?php
    include '../../render/connection.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $product_category = $_POST['product_category'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_stocks = $_POST['product_stocks'];

        // Insert data into services table
        $sql = "INSERT INTO products (category, product_name, price, stocks) VALUES ('$product_category', '$product_name', '$product_price', '$product_stocks')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../admin/web_content/inventory.php";
            // Redirect back to the previous window using window.location
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message
            echo "Error adding package: " . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    }
?>
