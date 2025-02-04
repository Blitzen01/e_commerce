<?php
    include '../../render/connection.php';

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $parts_id = $_POST['parts_id'];
        $parts_category = $_POST['parts_category'];
        $parts_name = $_POST['parts_name'];
        $parts_price = $_POST['parts_price'];
        $parts_stocks = $_POST['parts_stocks'];

        // Update data in the products table
        $sql = "UPDATE computer_parts SET parts_category = '$parts_category', parts_name = '$parts_name', price = '$parts_price', stocks = '$parts_stocks' WHERE id = '$parts_id'";
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
