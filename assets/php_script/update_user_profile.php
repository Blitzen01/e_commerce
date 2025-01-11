<?php
    // Include your connection file
    include '../../render/connection.php';

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $user_id = $_POST['user_id'];
        $full_name = $_POST['full_name'];
        $address = $_POST['address'];
        $contact_number = $_POST['contact_number'];
        $birthday = $_POST['birthday'];
        $gender = $_POST['gender'];
        $bio = $_POST['bio'];
        $age = $_POST['age'];

        // Prepare the SQL query to update the user's profile
        $sql = "UPDATE user_account SET 
                    full_name = '$full_name', 
                    address = '$address', 
                    contact_number = '$contact_number', 
                    birthday = '$birthday', 
                    gender = '$gender', 
                    bio = '$bio',
                    age = '$age'  
                WHERE id = '$user_id'";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // If the update was successful, redirect to the profile page or show success message
            echo '<script type="text/javascript">';
            echo 'window.location.href = "../../user/user_profile.php";';  // Update this URL to your profile page
            echo '</script>';
        } else {
            echo "Error updating profile: " . mysqli_error($conn);
        }
    }
?>
