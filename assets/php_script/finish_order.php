<?php
    include '../../render/connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Assuming a connection to your database is already established
        $order_id = $_POST['order_id'];

        // Fetch order data from order_booking based on the order_id
        $sql = "SELECT * FROM order_booked WHERE id = '$order_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $email = $row['email'];
                $address = $row['address'];
                $contact_number = $row['contact_number'];
                $date = $row['date'];
                $item = $row['item'];
                $quantity = $row['quantity'];
                $price = $row['price'];
                $status = "Order Finished";
                $mop = $row['mop'];
                
                // Correct the SQL by adding a comma between $status and $mop
                $insert_sql = "INSERT INTO order_transaction_history (name, email, address, contact_number, transaction_date, item, quantity, total_amount, status, mop)
                VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$item', '$quantity', '$price', '$status', '$mop')";

                if (mysqli_query($conn, $insert_sql)) {
                    // After successful insertion, delete the order from order_booking
                    $delete_sql = "DELETE FROM order_booked WHERE id = '$order_id'";
                    if (mysqli_query($conn, $delete_sql)) {
                        // Redirect to the specified page
                        $redirectUrl = "../../admin/web_content/order.php"; 
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "' . $redirectUrl . '";';
                        echo '</script>';
                        exit; // Ensure no further code is executed after redirect
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
    }
?>
