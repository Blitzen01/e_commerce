<?php
    include '../../render/connection.php';

    date_default_timezone_set('Asia/Manila');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $senderId = $_POST['senderId'];
        $receiver_id = "admin";
        $userMessage = $_POST['userMessage'];
        $timeStamp =  date('Y-m-d H:i:s');
        

        // Insert data into admin_account table
        $sql = "INSERT INTO messages (sender_id, receiver_id, message, timestamp) VALUES ('$senderId', '$receiver_id', '$userMessage', '$timeStamp')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../user/index.php?chatbox=open";
            // Redirect to admin dashboard
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message
            echo "Error adding staff: " . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    }
?>
