<?php
include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Assuming a connection to your database is already established
    $order_id = $_POST['order_id'];

    // Fetch order data from order_booking based on the order_id
    $sql = "SELECT * FROM order_booked WHERE id = '$order_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $mop = $row['mop'];
            if ($mop == "otc") { // Corrected comparison operator
                $status = "Ready for Pick Up";
            } else if ($mop == "cod") { // Corrected comparison operator
                $status = "Ready for Delivery";
            }

            // Update the order status in the database
            $update_sql = "UPDATE order_booked SET status = '$status' WHERE id = '$order_id'";
            if (mysqli_query($conn, $update_sql)) {
                $redirectUrl = "../../admin/web_content/order.php"; 
                echo '<script type="text/javascript">';
                echo 'window.location.href = "' . $redirectUrl . '";';
                echo '</script>';
            } else {
                echo "Error updating status: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Order not found!";
    }
}
?>
