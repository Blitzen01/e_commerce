<?php
    include '../../render/connection.php';

    date_default_timezone_set('Asia/Manila');

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        $comment = $_POST['comments'];
        $rating = $_POST['rating'];
        $category = $_POST['category'];
        $subject = $_POST['subject'];

        date_default_timezone_set('Asia/Manila');

        $date = date('Y-m-d');
        $time = date('h:i A');

        // Insert data into services table
        $sql = "INSERT INTO rating (comment, rating, category, subject, date, time) VALUES ('$comment', '$rating', '$category', '$subject', '$date', '$time')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $redirectUrl = "../../user/index.php";
            // Redirect back to the previous window using window.location
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            // Error message
            echo "Error adding package: " . mysqli_error($conn);
        }

        // Close database connection
        mysqli_close($conn);
    }
?>