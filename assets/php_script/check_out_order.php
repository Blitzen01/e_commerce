<?php
session_start();
include '../../render/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ensure the required POST data is set
    if (isset($_POST['product_id']) && isset($_POST['mop'])) {
        $productIds = $_POST['product_id']; // Selected product IDs (array or single value)
        $mop = $_POST['mop']; // Mode of Payment
        $email = $_SESSION['email']; // Get email from session
        $totalPrice = 0;

        // Fetch user details
        $sql1 = "SELECT * FROM user_account WHERE email = '$email'";
        $result1 = mysqli_query($conn, $sql1);

        if ($result1 && mysqli_num_rows($result1) > 0) {
            $row1 = mysqli_fetch_assoc($result1);
            $address = $row1['address']; // User address
            $contact_number = $row1['contact_number']; // User contact number
            $date = date('Y-m-d'); // Current date
            $name = $row1['full_name'];
        } else {
            echo "User details not found.";
            exit;
        }

        // Ensure $productIds is an array for uniform processing
        if (!is_array($productIds)) {
            $productIds = [$productIds];
        }

        // Process each product ID
        foreach ($productIds as $productId) {
            // Fetch product details from product_cart
            $sql = "SELECT * FROM product_cart WHERE id = '$productId' AND email = '$email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);

                // Insert product into order_booking
                $productName = $row['product_name'];
                $quantity = $row['quantity'];
                $price = $row['total_price'];

                $insertSql = "INSERT INTO order_booking (email, name, address, contact_number, item, quantity, price, mop, date)
                              VALUES ('$email', '$name', '$address', '$contact_number', '$productName', '$quantity', '$price', '$mop', '$date')";
                $insertResult = mysqli_query($conn, $insertSql);

                if ($insertResult) {
                    $totalPrice += $price; // Add the price of the product to the total
                } else {
                    echo "Error inserting into order_booking: " . mysqli_error($conn);
                }

                // Clear the selected item from the product_cart after adding it to order_booking
                $deleteSql = "DELETE FROM product_cart WHERE id = '$productId' AND email = '$email'";
                mysqli_query($conn, $deleteSql);
            } else {
                echo "Product with ID $productId not found in the cart.";
            }
        }

        // Redirect back to the cart page
        $redirectUrl = "../../user/user_profile.php#order";
        echo '<script type="text/javascript">';
        echo 'window.location.href = "' . $redirectUrl . '";';
        echo '</script>';
    } else {
        echo "No product selected or mode of payment not specified.";
    }
}
?>
