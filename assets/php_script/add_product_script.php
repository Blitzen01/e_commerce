<?php
    include '../../render/connection.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $product_category = $_POST['product_category'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_stocks = $_POST['product_stocks'];

        // Handle file upload
        $image_tmp = $_FILES['product_image']['tmp_name'];
        $image_name = $_FILES['product_image']['name']; // Get only the file name with extension
        $upload_dir = '../../assets/image/product_image/';
        $image_path = $upload_dir . basename($image_name);

        // Check if the file is valid and move it to the upload directory
        if (move_uploaded_file($image_tmp, $image_path)) {
            // File upload successful
        } else {
            echo "Error uploading image.";
            exit;
        }

        // Insert data into products table
        $sql = "INSERT INTO products (category, product_name, price, stocks, product_image) VALUES ('$product_category', '$product_name', '$product_price', '$product_stocks', '$image_name')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../admin/web_content/inventory.php";
            // Redirect back to the previous window using window.location
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message
            echo "Error adding product: " . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    }
?>
