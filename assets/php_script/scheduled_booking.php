<?php
session_start();

$email = $_SESSION['email'];
include '../../render/connection.php';

// Retrieve form data
$type_of_booking = $_POST['type_of_booking'];
$dateInput = $_POST['dateInput'];
$timeInput = $_POST['timeInput'];
$remarks = $_POST['remarks'];

// Fetch user details from the database using email
$userQuery = "SELECT * FROM user_account WHERE email = '$email'";
$result = mysqli_query($conn, $userQuery);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['full_name'];
    $email = $row['email'];
    $address = $row['address'];  // Corrected field name
    $contact_number = $row['contact_number'];

    // Insert data into 'booked' table
    $sql = "INSERT INTO booked (name, email, address, contact_number, type_of_booking, date, time, remarks) 
            VALUES ('$name', '$email', '$address', '$contact_number', '$type_of_booking', '$dateInput', '$timeInput', '$remarks')";

    if (mysqli_query($conn, $sql)) {
        $redirectUrl = "../../user/index.php";
            // Redirect back to the previous window using window.location
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
