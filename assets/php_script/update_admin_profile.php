<?php
    // Include your connection file
    include '../../render/connection.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $user_id = $_POST['user_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $username = $_POST['username'];
        $contact_number = $_POST['contact_number'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $bio = $_POST['bio'];

        // Prepare the SQL query to update the user's profile
        $sql = "UPDATE admin_account SET 
                    first_name = '$first_name', 
                    last_name = '$last_name', 
                    username = '$username', 
                    contact_number = '$contact_number', 
                    birthday = '$birthday', 
                    gender = '$gender', 
                    bio = '$bio' 
                WHERE id = '$user_id'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // If the update was successful, redirect to the profile page or show success message
            echo '<script type="text/javascript">';
            echo 'window.location.href = "../../admin/web_content/account_settings.php";';  // Update this URL to your profile page
            echo '</script>';
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }
    }
?>
