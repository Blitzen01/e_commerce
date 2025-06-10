<?php
include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['order_id'])) {
        $order_id = intval($_POST['order_id']);

        // Fetch order data
        $sql = "SELECT * FROM order_booked WHERE id = '$order_id'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $email = $row['email'];
                $address = $row['address'];
                $contact_number = $row['contact_number'];
                $date = $row['date'];
                $item = $row['item']; // full item name with "Custom Build:"
                $quantity = intval($row['quantity']);
                $price = $row['price'];
                $mop = $row['mop'];

                // Check if it's a custom build
                if (strpos($item, "Custom Build:") === 0) {
                    // Strip "Custom Build:" and split parts
                    $items_string = trim(str_replace("Custom Build:", "", $item));
                    $parts_array = array_map('trim', explode(",", $items_string));

                    foreach ($parts_array as $part_name) {
                        $part_sql = "SELECT * FROM computer_parts WHERE parts_name = '$part_name'";
                        $part_result = mysqli_query($conn, $part_sql);

                        if (mysqli_num_rows($part_result) > 0) {
                            $part_data = mysqli_fetch_assoc($part_result);
                            $new_stock = intval($part_data['stocks']) - $quantity;

                            if ($new_stock >= 0) {
                                $update_part_sql = "UPDATE computer_parts SET stocks = '$new_stock' WHERE parts_name = '$part_name'";
                                mysqli_query($conn, $update_part_sql);
                            } else {
                                echo "Not enough stock for part: $part_name<br>";
                                exit;
                            }
                        } else {
                            echo "Part not found in computer_parts table: $part_name<br>";
                            exit;
                        }
                    }

                } else {
                    // Check package table
                    $package_sql = "SELECT * FROM package WHERE package_name = '$item'";
                    $package_result = mysqli_query($conn, $package_sql);

                    if (mysqli_num_rows($package_result) > 0) {
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
                        // Check products table
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
                            // Check computer_parts table
                            $parts_sql = "SELECT * FROM computer_parts WHERE parts_name = '$item'";
                            $parts_result = mysqli_query($conn, $parts_sql);

                            if (mysqli_num_rows($parts_result) > 0) {
                                $part_data = mysqli_fetch_assoc($parts_result);
                                $new_stock = intval($part_data['stocks']) - $quantity;

                                if ($new_stock >= 0) {
                                    $update_part_sql = "UPDATE computer_parts SET stocks = '$new_stock' WHERE parts_name = '$item'";
                                    mysqli_query($conn, $update_part_sql);
                                } else {
                                    echo "Not enough stock in the computer_parts table!<br>";
                                    exit;
                                }
                            } else {
                                echo "Item not found in any table!<br>";
                                exit;
                            }
                        }
                    }
                }

                // Insert to transaction history with full item name
                $insert_sql = "INSERT INTO order_transaction_history (name, email, address, contact_number, transaction_date, item, quantity, total_amount, mop, status)
                VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$item', '$quantity', '$price', '$mop', 'Order Finished')";

                if (mysqli_query($conn, $insert_sql)) {
                    $delete_sql = "DELETE FROM order_booked WHERE id = '$order_id'";
                    if (mysqli_query($conn, $delete_sql)) {
                        echo '<script>window.location.href = "../../admin/web_content/order.php";</script>';
                    } else {
                        echo "Error deleting order from order_booked!<br>";
                    }
                } else {
                    echo "Error inserting into order_transaction_history!<br>";
                }
            }
        } else {
            echo "No order found with the given ID.<br>";
        }
    } else {
        echo "No order ID received.<br>";
    }
}
?>
