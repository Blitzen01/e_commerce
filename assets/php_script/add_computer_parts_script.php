<?php
    include '../../render/connection.php';

    // Check if form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $parts_category = $_POST['parts_category'];
        $parts_name = $_POST['parts_name'];
        $price = $_POST['price'];
        $stock = $_POST['stock'];

        // Check if the file is uploaded
        if (isset($_FILES['computer_parts_image']) && $_FILES['computer_parts_image']['error'] == 0) {
            // Handle file upload
            $image_tmp = $_FILES['computer_parts_image']['tmp_name'];
            $image_name = $_FILES['computer_parts_image']['name']; // Get only the file name with extension
            $upload_dir = '../../assets/image/computer_parts_image/'; // Change the upload directory
            $image_path = $upload_dir . basename($image_name);

            // Check if the file is valid and move it to the upload directory
            if (move_uploaded_file($image_tmp, $image_path)) {
                // File upload successful
            } else {
                echo "Error uploading image.";
                exit;
            }
        } else {
            echo "No image uploaded or there was an error with the file.";
            exit;
        }

        // Insert data into computer_parts table
        $sql = "INSERT INTO computer_parts (image, parts_category, price, stocks, parts_name) 
                VALUES ('$image_name', '$parts_category', '$price', '$stock', '$parts_name')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../admin/web_content/inventory.php"; // Update the redirect URL if necessary
            // Redirect back to the computer parts page using window.location
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message
            echo "Error adding computer part: " . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    }
?>
