<?php
    include '../../render/connection.php';

    date_default_timezone_set('Asia/Manila');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $first_name = $_POST['staff_first_name'];
        $last_name = $_POST['staff_last_name'];
        $username = $_POST['staff_username'];
        $email = $_POST['staff_email'];
        $contact_number = $_POST['staff_contact_number'];
        $position = $_POST['staff_position'];

        // Insert data into admin_account table
        $sql = "INSERT INTO admin_account (first_name, last_name, username, email, password, contact_number, role) VALUES ('$first_name', '$last_name', '$username', '$email', '$username', '$contact_number', '$position')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../admin/web_content/staff.php";
            // Redirect to admin dashboard
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message
            echo "Error adding staff: " . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    }
?>
