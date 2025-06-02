<?php

include '../../render/connection.php';

if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $id = intval($_GET['id']);
    $stock = intval($_GET['quantity']);
    $mop = $_GET['mop'];

    // Query to get user details
    $user = "SELECT * FROM user_account WHERE email = '$email'";
    $product = "SELECT * FROM computer_parts WHERE id = '$id'";

    $result = mysqli_query($conn, $user);
    $result1 = mysqli_query($conn, $product);

    if ($result && $result1) {
        // Fetch user details
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['full_name'];
            $address = $row['address'];
            $contact_number = $row['contact_number'];
        }

        // Fetch product details
        while ($row = mysqli_fetch_assoc($result1)) {
            $product_name = $row['parts_name'];
            $price = $stock*$row['price'];
        }

        // Set timezone to Philippine Time
        date_default_timezone_set('Asia/Manila');

        // Get the current date and time
        $date = date("Y-m-d H:i:s");

        // Query to insert data into the booking table
        $insertQuery = "INSERT INTO order_booking (name, email, address, contact_number, date, item, quantity, price, mop) 
                        VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$product_name', $stock, $price, '$mop')";

        if (mysqli_query($conn, $insertQuery)) {
            $redirectUrl = "../../user/user_profile.php#profile_order_view";
            // Redirect back to the previous window using window.location
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Error fetching user or product details.";
    }
} else {
    echo "No product selected.";
    exit;
}

?>
