<?php
session_start();

$email = $_SESSION['email']; // Get the session email
include '../../render/connection.php';

// Retrieve form data
$type_of_booking = $_POST['type_of_booking'];
$kind_of_booking = $_POST['kind_of_booking'];
$dateInput = $_POST['dateInput'];
$timeInput = $_POST['timeInput'];
$mob = $_POST['mob'];
$remarks = $_POST['remarks'];

// Assign price based on kind_of_booking
switch ($kind_of_booking) {
    case 'Laptop Repair':
        $price = 800;
        break;
    case 'Desktop Repair':
        $price = 700;
        break;
    case 'CCTV Repair':
        $price = 550;
        break;
    case 'Board Level':
        $price = 2500;
        break;
    case 'Laptop Installation':
        $price = 250;
        break;
    case 'Desktop Installation':
        $price = 200;
        break;
    case 'Printer':
        $price = 150;
        break;
    case 'CCTV Walk In':
        $price = 400;
        break;
    case 'CCTV On Site':
        $price = 800;
        break;
    default:
        $price = 0; // Default price if no match
}

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

// Get the current time in the "H:i A" format
$currentTime = date('h:i A');

// Fetch user details from the database using the session email
$userQuery = "SELECT * FROM user_account WHERE email = '$email'";
$result = mysqli_query($conn, $userQuery);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['full_name'];
    $address = $row['address'];
    $contact_number = $row['contact_number'];

    // Insert data into 'booked' table
    $sql = "INSERT INTO booked 
            (name, email, address, contact_number, type_of_booking, kind_of_booking, price, date, time, mob, remarks) 
            VALUES 
            ('$name', '$email', '$address', '$contact_number', '$type_of_booking', '$kind_of_booking', '$price', '$dateInput', '$currentTime', '$mob', '$remarks')";

    if (mysqli_query($conn, $sql)) {
        $redirectUrl = "../../user/user_profile.php#profile_booking_view";
        // Redirect back to the user profile page
        echo '<script type="text/javascript">';
        echo 'window.location.href = "' . $redirectUrl . '";';
        echo '</script>';
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "User not found.";
}

// Close the database connection
mysqli_close($conn);
?>
