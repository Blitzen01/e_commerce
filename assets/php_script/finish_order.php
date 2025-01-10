<?php
include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the order_id is set
    if (isset($_POST['order_id'])) {
        $order_id = intval($_POST['order_id']);  // Make sure it's an integer

        // Fetch order data from order_booking based on the order_id
        $sql = "SELECT * FROM order_booked WHERE id = '$order_id'";

        $result = mysqli_query($conn, $sql);

        if ($result) {
            $rowCount = mysqli_num_rows($result);
            
            if ($rowCount > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $name = $row['name'];
                    $email = $row['email'];
                    $address = $row['address'];
                    $contact_number = $row['contact_number'];
                    $date = $row['date'];
                    $item = $row['item'];
                    $quantity = $row['quantity'];
                    $price = $row['price'];
                    $mop = $row['mop'];

                    // Insert data into order_transaction_history
                    $insert_sql = "INSERT INTO order_transaction_history (name, email, address, contact_number, transaction_date, item, quantity, total_amount, mop)
                    VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$item', '$quantity', '$price', '$mop')";

                    if (mysqli_query($conn, $insert_sql)) {
                        // After successful insertion, delete the order from order_booking
                        $delete_sql = "DELETE FROM order_booked WHERE id = '$order_id'";
                        if (mysqli_query($conn, $delete_sql)) {
                            // Redirect to the specified page
                            $redirectUrl = "../../admin/web_content/order.php"; 
                            echo '<script type="text/javascript">';
                            echo 'window.location.href = "' . $redirectUrl . '";';
                            echo '</script>';
                        } else {
                            echo "Error deleting order from order_booking!<br>";
                        }
                    } else {
                        echo "Error inserting order into order_transaction_history!<br>";
                    }
                }
            } else {
                echo "No order found with the given ID.<br>"; // No rows returned
            }
        } else {
            echo "Error executing query: " . mysqli_error($conn) . "<br>"; // Query execution failed
        }
    } else {
        echo "No order ID received.<br>";
    }
}
?>
