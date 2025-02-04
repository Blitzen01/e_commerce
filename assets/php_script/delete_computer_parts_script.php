<?php
    include '../../render/connection.php';

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $parts_id = $_POST['parts_ID'];

        // Delete the product from the database
        $sql = "DELETE FROM computer_parts WHERE id = '$parts_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../admin/web_content/inventory.php";
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message if the deletion fails
            echo "Error deleting product: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    }
?>
