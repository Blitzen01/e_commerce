<?php
    include '../../render/connection.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $product_category = $_POST['product_category'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_stocks = $_POST['product_stocks'];

        // Handle Image Upload
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
            $image_tmp = $_FILES['product_image']['tmp_name'];
            $image_name = $_FILES['product_image']['name']; // Get only the file name with extension
            $image_size = $_FILES['product_image']['size'];
            $image_type = $_FILES['product_image']['type'];

            // Define upload directory and file path
            $upload_dir = '../../assets/image/product_image/';
            $image_path = $upload_dir . basename($image_name);

            // Check if file is an image (optional)
            if (getimagesize($image_tmp)) {
                // Move the uploaded image to the desired directory
                if (move_uploaded_file($image_tmp, $image_path)) {
                    // Insert product data into the database, including only the image file name
                    $sql = "INSERT INTO products (category, product_name, price, stocks, product_image) 
                            VALUES ('$product_category', '$product_name', '$product_price', '$product_stocks', '$image_name')";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        // Redirect to inventory page after successful insertion
                        $redirectUrl = "../../admin/web_content/inventory.php";
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "' . $redirectUrl . '";';
                        echo '</script>';
                    } else {
                        // Error message if the query fails
                        echo "Error adding product: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error uploading image.";
                }
            } else {
                echo "The file is not a valid image.";
            }
        } else {
            echo "No image uploaded or error in file upload.";
        }

        // Close the database connection
        mysqli_close($conn);
    }
?>
