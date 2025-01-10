<?php
include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'];

    // Fetch order data from order_booking based on the order_id
    $sql = "SELECT * FROM order_booked WHERE id = '$order_id'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['name'];
            $email = $row['email'];
            $address = $row['address'];
            $contact_number = $row['contact_number'];
            $date = $row['date'];
            $item = $row['item'];
            $quantity = intval($row['quantity']);
            $price = $row['price'];
            $status = "Order Finished";
            $mop = $row['mop'];

            // Deduct the quantity from the products table
            $productQuery = "SELECT * FROM products WHERE product_name = '$item'";
            $productResult = mysqli_query($conn, $productQuery);

            if ($productResult && mysqli_num_rows($productResult) > 0) {
                $product = mysqli_fetch_assoc($productResult);
                $currentStock = intval($product['stocks']);

                if ($currentStock >= $quantity) {
                    $newStock = $currentStock - $quantity;
                    $updateStockQuery = "UPDATE products SET stocks = $newStock WHERE product_name = '$item'";
                    
                    if (!mysqli_query($conn, $updateStockQuery)) {
                        echo "Error updating product stock: " . mysqli_error($conn);
                        exit;
                    }
                } else {
                    echo "Insufficient stock for the product: $item.";
                    exit;
                }
            } else {
                echo "Product not found in the database!";
                exit;
            }

            // Insert order into order_transaction_history
            $insert_sql = "INSERT INTO order_transaction_history (name, email, address, contact_number, transaction_date, item, quantity, total_amount, status, mop)
            VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$item', $quantity, $price, '$status', '$mop')";

            if (mysqli_query($conn, $insert_sql)) {
                // Delete the order from order_booked
                $delete_sql = "DELETE FROM order_booked WHERE id = '$order_id'";
                if (mysqli_query($conn, $delete_sql)) {
                    // Redirect to the specified page
                    $redirectUrl = "../../admin/web_content/order.php";
                    echo '<script type="text/javascript">';
                    echo 'window.location.href = "' . $redirectUrl . '";';
                    echo '</script>';
                    exit;
                } else {
                    echo "Error deleting order from order_booked!";
                    exit;
                }
            } else {
                echo "Error inserting order into order_transaction_history!";
                exit;
            }
        }
    } else {
        echo "Order not found!";
    }
}
?>
