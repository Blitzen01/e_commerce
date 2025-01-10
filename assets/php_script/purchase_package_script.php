<?php
include '../../render/connection.php';

if (isset($_GET['email'], $_GET['id'], $_GET['quantity'], $_GET['mop'])) {
    $email = mysqli_real_escape_string($conn, $_GET['email']);
    $id = intval($_GET['id']);
    $stock = intval($_GET['quantity']);
    $mop = mysqli_real_escape_string($conn, $_GET['mop']);

    // Query to get user details
    $userQuery = "SELECT full_name, address, contact_number FROM user_account WHERE email = '$email'";
    $productQuery = "SELECT package_name, package_price FROM package WHERE id = $id";

    $userResult = mysqli_query($conn, $userQuery);
    $productResult = mysqli_query($conn, $productQuery);

    if ($userResult && $productResult && mysqli_num_rows($userResult) > 0 && mysqli_num_rows($productResult) > 0) {
        // Fetch user details
        $userData = mysqli_fetch_assoc($userResult);
        $name = $userData['full_name'];
        $address = $userData['address'];
        $contact_number = $userData['contact_number'];

        // Fetch product details
        $productData = mysqli_fetch_assoc($productResult);
        $product_name = $productData['product_name'];
        $price = $stock * $productData['price'];

        // Set timezone to Philippine Time
        date_default_timezone_set('Asia/Manila');
        $date = date("Y-m-d H:i:s");

        // Query to insert data into the order_booking table
        $insertQuery = "
            INSERT INTO order_booking (name, email, address, contact_number, date, item, quantity, price, mop)
            VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$product_name', $stock, $price, '$mop')
        ";

        if (mysqli_query($conn, $insertQuery)) {
            $redirectUrl = "../../user/index.php";
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            echo "Error inserting order: " . mysqli_error($conn);
        }
    } else {
        echo "Error fetching user or product details.";
    }
} else {
    echo "Missing required parameters.";
    exit;
}
?>
