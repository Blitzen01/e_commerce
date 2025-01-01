<?php
session_start();
include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure user is logged in
    if (!isset($_SESSION['email'])) {
        die("User not logged in");
    }

    $email = $_SESSION['email'];
    $product_name = mysqli_real_escape_string($conn, $_POST['product_name']);
    $quantity = (int)$_POST['quantity'];
    $price = (float)$_POST['price'];
    $total_price = $quantity * $price;

    // Insert data into the product_cart table
    $sql = "INSERT INTO product_cart (email, product_name, quantity, total_price) 
            VALUES ('$email', '$product_name', '$quantity', '$total_price')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to the cart page or show a success message
        header("Location: ../../user/cart.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>