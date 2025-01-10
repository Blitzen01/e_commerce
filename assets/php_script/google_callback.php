<?php
// Include database connection
include "../../render/connection.php";

// Function to save the profile picture
function saveProfilePicture($url, $email)
{
    $directory = "../../assets/image/profile_picture/";
    $filename = $email . ".jpg";  // Save the file with the email as the filename
    $filePath = $directory . $filename;

    // Create the directory if it doesn't exist
    if (!file_exists($directory)) {
        if (!mkdir($directory, 0755, true)) {
            return false; // Failed to create directory
        }
    }

    // Download and save the profile picture
    $imageData = file_get_contents($url);
    if ($imageData === false) {
        return false; // Failed to download image
    }

    // Save the file to the specified directory
    if (file_put_contents($filePath, $imageData) === false) {
        return false; // Failed to write file
    }

    return $filename; // Return only the filename (not the full path)
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input from the Google login response
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        echo json_encode(['success' => false, 'error' => 'Invalid JSON input.']);
        exit;
    }

    // Extract Google user data from the response
    $user_givenName = mysqli_real_escape_string($conn, $input['credential']['given_name']);
    $user_familyName = mysqli_real_escape_string($conn, $input['credential']['family_name']);
    $user_fullname = mysqli_real_escape_string($conn, $input['credential']['name']);
    $user_email = mysqli_real_escape_string($conn, $input['credential']['email']);
    $user_picture_url = mysqli_real_escape_string($conn, $input['profile_picture']);

    // Save the profile picture to the specified directory
    $profilePictureFilename = saveProfilePicture($user_picture_url, $user_email);
    if ($profilePictureFilename === false) {
        echo json_encode(['success' => false, 'error' => 'Failed to save profile picture.']);
        exit;
    }

    // Check if the user already exists in the database
    $sql = "SELECT * FROM user_account WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $user_email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // If the user doesn't exist, insert them into the database
        $insert_sql = "INSERT INTO user_account (email, first_name, last_name, full_name, profile_picture, is_new) VALUES (?, ?, ?, ?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sssss", $user_email, $user_givenName, $user_familyName, $user_fullname, $profilePictureFilename, '0');

        if (!$insert_stmt->execute()) {
            echo json_encode(['success' => false, 'error' => 'Failed to insert user.']);
            exit;
        }
    }

    // Set the session for the user's email
    session_start();
    $_SESSION['email'] = $user_email;

    // Return a success response
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>
