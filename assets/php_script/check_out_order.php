<?php
session_start();
include '../../render/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the required POST data is set
    if (isset($_POST['product_id']) && isset($_POST['mop'])) {
        $mop = $_POST['mop']; // Mode of Payment
        $email = $_SESSION['email']; // Get email from session
        $totalPrice = 0;

        // Fetch user details
        $sql1 = "SELECT * FROM user_account WHERE email = '$email'";
        $result1 = mysqli_query($conn, $sql1);

        if ($result1 && mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $address = $row1['address']; // Get address from user_account table
            $contact_number = $row1['contact_number']; // Get contact number from user_account table
            $date = date('Y-m-d'); // Get current date
        } else {
            echo "User details not found.";
            exit;
        }

        // Get the selected product ID from POST
        $productId = $_POST['product_id'];

        // Fetch product details from product_cart
        $sql = "SELECT * FROM product_cart WHERE id = '$productId' AND email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            // Insert product into order_booking
            $name = $row['name'];
            $productName = $row['product_name'];
            $quantity = $row['quantity'];
            $price = $row['total_price'];

            $insertSql = "INSERT INTO order_booking (email, name, address, contact_number, product_name, quantity, total_price, mop, order_date)
                          VALUES ('$email', '$name', '$address', '$contact_number', '$productName', '$quantity', '$price', '$mop', '$date')";
            $insertResult = mysqli_query($conn, $insertSql);

            if ($insertResult) {
                $totalPrice += $price; // Add the price of the product to the total
            } else {
                echo "Error inserting into order_booking: " . mysqli_error($conn);
            }
        } else {
            echo "Product not found in the cart.";
        }

        // Clear the selected item from the product_cart after adding it to order_booking
        $deleteSql = "DELETE FROM product_cart WHERE id = '$productId' AND email = '$email'";
        mysqli_query($conn, $deleteSql);

        // Output the total price of the order
        echo "Order placed successfully! Total: &#8369; $totalPrice";
    } else {
        echo "No product selected or mode of payment not specified.";
    }
}
?>
