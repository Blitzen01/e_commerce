<?php
// Include database connection
include "../../render/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the file input is set and no errors occurred
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        // Define the upload directory
        $uploadDir = '../../assets/image/profile_picture/';
        $fileTmpPath = $_FILES['profile_picture']['tmp_name'];
        $fileName = basename($_FILES['profile_picture']['name']);

        // Sanitize the file name to prevent directory traversal attacks
        $safeFileName = preg_replace('/[^a-zA-Z0-9\-_\.]/', '_', $fileName);
        $targetFilePath = $uploadDir . $safeFileName;

        // Ensure the upload directory exists
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        session_start();
        $email = $_SESSION['email']; // Assuming the user's email is stored in the session

        // Fetch the previous profile picture file name from the database
        $fetchSql = "SELECT profile_picture FROM user_account WHERE email = ?";
        $fetchStmt = $conn->prepare($fetchSql);
        $fetchStmt->bind_param("s", $email);
        $fetchStmt->execute();
        $result = $fetchStmt->get_result();
        $row = $result->fetch_assoc();

        if ($row && !empty($row['profile_picture'])) {
            $oldProfilePicture = $uploadDir . $row['profile_picture'];

            // Delete the old profile picture if it exists
            if (file_exists($oldProfilePicture)) {
                unlink($oldProfilePicture);
            }
        }

        // Move the uploaded file to the target directory
        if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
            // Update the profile picture in the database
            $sql = "UPDATE user_account SET profile_picture = ? WHERE email = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $safeFileName, $email);

            if ($stmt->execute()) {
                // If the update was successful, redirect to the profile page or show success message
                echo '<script type="text/javascript">';
                echo 'window.location.href = "../../user/user_profile.php";';  // Update this URL to your profile page
                echo '</script>';
            } else {
                // Handle database error
                echo "Failed to update profile picture in the database.";
            }
        } else {
            // Handle file upload error
            echo "Failed to upload the file.";
        }
    } else {
        // Handle errors with the file upload process
        echo "No file uploaded or an error occurred.";
    }
} else {
    echo "Invalid request method.";
}
?>
