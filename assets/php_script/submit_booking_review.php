<?php

// Include database connection
include "../../render/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $booking_id = intval($_POST['booking_id']);
    $remarks = htmlspecialchars($_POST['remarks']);
    $booking_reference = htmlspecialchars($_POST['booking_reference']);
    $rating = intval($_POST['rating']);

    // Validate rating
    if ($rating < 1 || $rating > 5) {
        die("Invalid rating.");
    }

    // Handle file upload
    $upload_dir = "../../assets/image/booking_review_image/";
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true); // Create directory if it doesn't exist
    }

    $file_name = basename($_FILES['picture']['name']);
    $file_path = $upload_dir . $file_name;

    // Validate file type
    $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['picture']['type'], $allowed_types)) {
        die("Invalid file type. Only JPG, PNG, and GIF are allowed.");
    }

    // Move uploaded file
    if (!move_uploaded_file($_FILES['picture']['tmp_name'], $file_path)) {
        die("Failed to upload picture.");
    }

    // Save review to database
    $stmt = $conn->prepare("INSERT INTO booking_feedback (transaction_id, picture, remarks, rating) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("issi", $booking_id, $file_name, $remarks, $rating);

    if ($stmt->execute()) {
        // Redirect to a success page or display a success message
        echo '<script type="text/javascript">';
        echo 'window.location.href = "../../user/user_profile.php";'; // Update this URL as needed
        echo '</script>';
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request.";
}
?>
