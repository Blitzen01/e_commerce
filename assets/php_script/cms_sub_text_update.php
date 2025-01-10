<?php
    include '../../render/connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the content ID and subtext from the POST data
    $content_id = $_POST['content_id'];
    $sub_text = $_POST['sub_text'];

    // Validate the data (optional, but recommended)
    if (empty($content_id) || empty($sub_text)) {
        // Handle error: required fields are empty
        echo "Error: Content ID or Subtext is missing.";
        exit;
    }

    // Sanitize the subtext to avoid SQL injection
    $sub_text = mysqli_real_escape_string($conn, $sub_text);

    // Prepare the SQL update query
    $sql = "UPDATE contents SET sub_text = '$sub_text' WHERE id = '$content_id'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Redirect to the specified page
        $redirectUrl = "../../admin/web_content/cms.php"; 
        echo '<script type="text/javascript">';
        echo 'window.location.href = "' . $redirectUrl . '";';
        echo '</script>';
    } else {
        // Error updating the database
        echo "Error: " . mysqli_error($conn);
        exit;
    }
} else {
    // If the request is not POST, redirect to an error page
    echo "Invalid request method.";
    exit;
}
?>
