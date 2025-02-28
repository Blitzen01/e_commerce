<?php
// Include your connection file
include '../../render/connection.php';

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

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

    // Calculate age dynamically
    $birthdate = new DateTime($birthday);
    $today = new DateTime(); // Gets the current date based on the timezone set
    $age = $birthdate->diff($today)->y; // Computes the difference in years

    // Use prepared statement to prevent SQL injection
    $sql = "UPDATE user_account SET 
                full_name = ?, 
                address = ?, 
                contact_number = ?, 
                birthday = ?, 
                gender = ?, 
                bio = ?, 
                age = ?  
            WHERE id = ?";

    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssii", $full_name, $address, $contact_number, $birthday, $gender, $bio, $age, $user_id);

    // Execute the query
    if (mysqli_stmt_execute($stmt)) {
        // Redirect after successful update
        echo '<script type="text/javascript">';
        echo 'window.location.href = "../../user/user_profile.php";'; // Redirect to profile page
        echo '</script>';
    } else {
        echo "Error updating profile: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}

// Close the connection
mysqli_close($conn);
?>
