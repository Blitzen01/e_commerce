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
                    $quantity = intval($row['quantity']);
                    $price = $row['price'];
                    $mop = $row['mop'];

                    // Check if the item exists in the package table
                    $package_sql = "SELECT * FROM package WHERE package_name = '$item'";
                    $package_result = mysqli_query($conn, $package_sql);

                    if (mysqli_num_rows($package_result) > 0) {
                        // If item is in the package table, update the stocks
                        $package_data = mysqli_fetch_assoc($package_result);
                        $new_stock = intval($package_data['stocks']) - $quantity;

                        if ($new_stock >= 0) {
                            $update_package_sql = "UPDATE package SET stocks = '$new_stock' WHERE package_name = '$item'";
                            mysqli_query($conn, $update_package_sql);
                        } else {
                            echo "Not enough stock in the package table!<br>";
                            exit;
                        }
                    } else {
                        // If not in the package table, check the products table
                        $product_sql = "SELECT * FROM products WHERE product_name = '$item'";
                        $product_result = mysqli_query($conn, $product_sql);

                        if (mysqli_num_rows($product_result) > 0) {
                            $product_data = mysqli_fetch_assoc($product_result);
                            $new_stock = intval($product_data['stocks']) - $quantity;

                            if ($new_stock >= 0) {
                                $update_product_sql = "UPDATE products SET stocks = '$new_stock' WHERE product_name = '$item'";
                                mysqli_query($conn, $update_product_sql);
                            } else {
                                echo "Not enough stock in the products table!<br>";
                                exit;
                            }
                        } else {
                            echo "Item not found in both package and products tables!<br>";
                            exit;
                        }
                    }

                    // Insert data into order_transaction_history
                    $insert_sql = "INSERT INTO order_transaction_history (name, email, address, contact_number, transaction_date, item, quantity, total_amount, mop, status)
                    VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$item', '$quantity', '$price', '$mop', 'Order Finished')";

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
