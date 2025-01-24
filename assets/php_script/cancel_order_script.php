<?php
    include '../../render/connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Retrieve the order ID and cancellation reason from the POST request
        $order_id = $_POST['order_id'];
        $reason = $_POST['reason'];

        // Fetch order details from the `order_booking` table
        $sql = "SELECT * FROM order_booking WHERE id = '$order_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Check if the order exists
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['name'];
                    $email = $row['email'];
                    $address = $row['address'];
                    $contact_number = $row['contact_number'];
                    $item = $row['item'];
                    $quantity = $row['quantity'];
                    $price = $row['price'];
                    $status = "Cancelled: " . $reason; // Update the status with the cancellation reason
                    $mop = $row['mop']; // Mode of Payment
                    
                    // Get the current date and time in Asia/Manila timezone
                    $date = new DateTime("now", new DateTimeZone('Asia/Manila'));
                    $formatted_date = $date->format('Y-m-d H:i:s'); // Format as YYYY-MM-DD HH:MM:SS

                    // Insert the canceled order into the `order_transaction_history` table
                    $insert_sql = "INSERT INTO order_transaction_history (name, email, address, contact_number, transaction_date, item, quantity, total_amount, status, mop)
                    VALUES ('$name', '$email', '$address', '$contact_number', '$formatted_date', '$item', '$quantity', '$price', '$status', '$mop')";

                    if (mysqli_query($conn, $insert_sql)) {
                        // Delete the canceled order from the `order_booking` table
                        $delete_sql = "DELETE FROM order_booking WHERE id = '$order_id'";
                        if (mysqli_query($conn, $delete_sql)) {
                            // Redirect the user to their profile page
                            $redirectUrl = "../../user/user_profile.php";
                            echo '<script type="text/javascript">';
                            echo 'window.location.href = "' . $redirectUrl . '";';
                            echo '</script>';
                            exit; // Ensure no further code execution after redirect
                        } else {
                            echo "Error deleting order from order_booking!";
                        }
                    } else {
                        echo "Error inserting order into order_transaction_history!";
                    }
                }
            } else {
                echo "Order not found!";
            }
        } else {
            echo "Error fetching order details!";
        }
    }
?>
