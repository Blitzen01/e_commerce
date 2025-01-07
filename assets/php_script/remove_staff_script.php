<?php
    include '../../render/connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $staff_id = $_POST['remove_staff']; // Get the selected staff ID from the form

        // Delete staff from admin_account table
        $sql = "DELETE FROM admin_account WHERE id = '$staff_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../admin/web_content/staff.php";
            // Redirect to the staff page
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message
            echo '<script type="text/javascript">';
            echo 'alert("Error removing staff: ' . mysqli_error($conn) . '");';
            echo 'window.history.back();';
            echo '</script>';
        }

        // Close database connection
        mysqli_close($conn);
    }
?>
