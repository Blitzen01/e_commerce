<?php
session_start();
include '../render/connection.php';
include '../assets/cdn/cdn_links.php';
include "../render/modals.php";

$email = $_SESSION['email']; // Get user email from session

$isSubmit = false; // Initialize the isSubmit condition variable

// Insert each item into order_booking table when checkout is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['mop']) && !empty($_POST['mop']) && isset($_POST['isSubmit']) && $_POST['isSubmit'] == 'true') {
    $mop = $_POST['mop']; // Mode of payment
    $date = date('Y-m-d H:i:s'); // Current timestamp for when the order is placed
    
    // Fetch user details
    $sqlUser = "SELECT * FROM user_account WHERE email = '$email'";
    $resultUser = mysqli_query($conn, $sqlUser);
    if ($resultUser && mysqli_num_rows($resultUser) > 0) {
        $user = mysqli_fetch_assoc($resultUser);
        $name = $user['full_name'];
        $address = $user['address'];
        $contact_number = $user['contact_number'];
    } else {
        echo "User not found.";
        exit;
    }

    // Fetch the cart items for the user
    $sqlCart = "SELECT * FROM product_cart WHERE email = '$email'";
    $resultCart = mysqli_query($conn, $sqlCart);

    if ($resultCart && mysqli_num_rows($resultCart) > 0) {
        while ($row = mysqli_fetch_assoc($resultCart)) {
            $product_name = $row['product_name']; // The name of the product or package
            $stock = $row['quantity']; // Quantity of the product

            // Check if the product is from the 'products' table or 'package' table
            $productQuery = "SELECT * FROM products WHERE product_name = '" . mysqli_real_escape_string($conn, $product_name) . "'";
            $productResult = mysqli_query($conn, $productQuery);

            if ($productResult && mysqli_num_rows($productResult) > 0) {
                // Product found in products table
                $product = mysqli_fetch_assoc($productResult);
                $price = $product['price']; // Get the individual product price
                $insertQuery = "
                    INSERT INTO order_booking (name, email, address, contact_number, date, item, quantity, price, mop)
                    VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$product_name', $stock, $price, '$mop')
                ";
            } else {
                // Product not found in products table, check in the package table
                $packageQuery = "SELECT * FROM package WHERE package_name = '" . mysqli_real_escape_string($conn, $product_name) . "'";
                $packageResult = mysqli_query($conn, $packageQuery);

                if ($packageResult && mysqli_num_rows($packageResult) > 0) {
                    // Package found in package table
                    $package = mysqli_fetch_assoc($packageResult);
                    $price = $package['package_price']; // Get the individual package price
                    $insertQuery = "
                        INSERT INTO order_booking (name, email, address, contact_number, date, item, quantity, price, mop)
                        VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$product_name', $stock, $price, '$mop')
                    ";
                } else {
                    // Product/package not found
                    echo "Product or package '$product_name' not found.";
                    continue; // Skip this item and continue with the next one
                }
            }

            // Execute the insert query
            if (mysqli_query($conn, $insertQuery)) {
                // Now, delete the item from the cart after successful insertion
                $deleteFromCartQuery = "DELETE FROM product_cart WHERE email = '$email' AND product_name = '$product_name'";
                mysqli_query($conn, $deleteFromCartQuery);
            } else {
                echo "Error inserting order for $product_name: " . mysqli_error($conn);
                exit;
            }
        }

        $redirectUrl = "user_profile.php#profile_order_view";
        // Redirect back to the previous window using window.location
        echo '<script type="text/javascript">';
        echo 'window.location.href = "' . $redirectUrl . '";';
        echo '</script>';
        exit;
    } else {
        echo "Your cart is empty.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>
        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>
        <?php include "chat.php"; ?>

        <?php
            // Fetch user details from the user_account table
            $sql1 = "SELECT * FROM user_account WHERE email = '$email'";
            $result1 = mysqli_query($conn, $sql1);

            if ($result1) {
                while ($user = mysqli_fetch_assoc($result1)) {
                    ?>
                    <div class="container mb-3">
                        <div class="ms-3">
                            <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#add_billing_address"><small>ADD NEW BILLING ADDRESS</small></button>
                            <button class="btn text-secondary" data-bs-toggle="modal" data-bs-target="#change_billing_address"><small>CHANGE BILLING ADDRESS</small></button>
                        </div>
                        <div class="row border rounded p-2">
                            <span><b><?php echo $user['full_name']; ?></b> (<?php echo $user['contact_number']; ?>)</span>
                            <span><?php echo $user['address']; ?></span>
                        </div>
                    </div>
                    <?php
                }
            }

            // Fetch the cart items for the user
            $sql = "SELECT * FROM product_cart WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);

            if ($result && mysqli_num_rows($result) > 0) {
                echo "<form method='POST' action='check_out_order.php'>";
                echo "<div class='container mb-3'>";
                echo '<input type="hidden" name="isSubmit" id="isSubmit" value="true">';

                $totalPrice = 0; // Variable to store the total price of the cart

                while ($row = mysqli_fetch_assoc($result)) {
                    // Fetch the product details based on product_name from the products table
                    $productImagePath = "../assets/image/placeholder.png"; // Default placeholder image
                    $productQuery = "SELECT * FROM products WHERE product_name = '" . mysqli_real_escape_string($conn, $row['product_name']) . "'";
                    $productResult = mysqli_query($conn, $productQuery);

                    if ($productResult && mysqli_num_rows($productResult) > 0) {
                        $product = mysqli_fetch_assoc($productResult);
                        $productImagePath = "../assets/image/product_image/" . $product['product_image'];
                    } else {
                        // If not found in products table, check in the package table
                        $packageQuery = "SELECT * FROM package WHERE package_name = '" . mysqli_real_escape_string($conn, $row['product_name']) . "'";
                        $packageResult = mysqli_query($conn, $packageQuery);

                        if ($packageResult && mysqli_num_rows($packageResult) > 0) {
                            $package = mysqli_fetch_assoc($packageResult);
                            $productImagePath = "../assets/image/package_image/" . $package['package_image'];
                        }
                    }

                    // If image still doesn't exist, use placeholder
                    if (!file_exists($productImagePath)) {
                        $productImagePath = "../assets/image/placeholder.png"; // Placeholder image
                    }
                    ?>
                    <div class="row border rounded p-2">
                        <div class="col-lg-2">
                            <img src="<?php echo $productImagePath; ?>" alt="Product Image" class="img-fluid">
                        </div>
                        <div class="col">
                            <h4><?php echo $row['product_name']; ?></h4>
                            <span class="me-5">Price: &#8369;<?php echo $row['total_price']; ?></span>
                            <span>Quantity: <?php echo $row['quantity']; ?></span>
                        </div>
                    </div>
                    <?php
                    $totalPrice += $row['total_price']; // Add the price of this item to the total
                }
                echo "</div>" ;

                // Add mode of payment options
                echo "<div class='container mb-3'>
                        <div class='float-start'>
                            <label for='mop'>Mode of Payment:</label>
                            <select class='form-select' name='mop' id='mop' required>
                                <option value='cod'>Cash on Delivery</option>
                                <option value='otc'>Over the Counter</option>
                            </select>
                        </div>
                    </div>" ;

                // Checkout button
                echo "<div class='container mt-5 mb-3 text-end'>
                        <h4><b>Total Price: </b> &#8369; $totalPrice</h4>
                        <button type='submit' class='btn btn-primary' onclick='submitForm()'>Checkout</button>
                    </div>";
                echo "</form>";
            } else {
                echo "Your cart is empty.";
            }
        ?>
        
        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>
    </body>
</html>
