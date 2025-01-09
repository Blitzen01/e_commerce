<?php
    include '../../render/connection.php';

    date_default_timezone_set('Asia/Manila');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $senderId = "admin";
        $receiver_id = $_POST['receiver_id'];
        $userMessage = $_POST['adminMessage'];
        $timeStamp =  date('Y-m-d H:i:s');
        $is_admin = 1;
        

        // Insert data into admin_account table
        $sql = "INSERT INTO messages (sender_id, receiver_id, message, timestamp, is_admin) VALUES ('$senderId', '$receiver_id', '$userMessage', '$timeStamp', '$is_admin')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../admin/web_content/chats.php";
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
