<?php

    // Include database connection
    include "../../render/connection.php";

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize and validate inputs
        $item_name = htmlspecialchars($_POST['item_name']);
        $remarks = htmlspecialchars($_POST['remarks']);
        $rating = intval($_POST['rating']);

        // Validate rating
        if ($rating < 1 || $rating > 5) {
            die("Invalid rating.");
        }

        // Handle file upload
        $upload_dir = "../../assets/image/order_review_image/";
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        $file_name = basename($_FILES['picture']['name']);
        $file_path = $upload_dir . $file_name;

        // Validate file type
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['picture']['type'], $allowed_types)) {
            die("Invalid file type.");
        }

        // Move uploaded file
        if (!move_uploaded_file($_FILES['picture']['tmp_name'], $file_path)) {
            die("Failed to upload picture.");
        }

        // Save review to database
        $stmt = $conn->prepare("INSERT INTO order_review (item_name, picture, remarks, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $item_name, $file_name, $remarks, $rating);

        if ($stmt->execute()) {
            // If the update was successful, redirect to the profile page or show success message
            echo '<script type="text/javascript">';
            echo 'window.location.href = "../../user/user_profile.php";';  // Update this URL to your profile page
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
