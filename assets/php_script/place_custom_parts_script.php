<?php
    session_start();
    include "../../render/connection.php";
    include "../../render/modals.php";

    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get form data
        $email = $_POST['email'];
        $parts = json_decode($_POST['parts'], true); // Decode JSON to associative array
        $paymentMethod = $_POST['paymentMethod'];

        // Initialize variables
        $item_names = [];
        $total_price = 0;

        // Fetch the details for each part
        foreach ($parts as $category => $part_name) {
            if (!empty($part_name)) {
                // Query to get the part price
                $sql_parts = "SELECT price FROM computer_parts WHERE parts_name = ?";
                $stmt = $conn->prepare($sql_parts);
                $stmt->bind_param("s", $part_name);
                $stmt->execute();
                $stmt->bind_result($price);
                $stmt->fetch();
                $stmt->close();

                // Add part name to item names list and add price to total
                $item_names[] = $part_name;
                $total_price += $price;
            }
        }

        // Prepend "Custom Build:" to the item names list
        $items = "Custom Build: " . implode(", ", $item_names);

        // Get the user details
        $sql_user = "SELECT * FROM user_account WHERE email = ?";
        $stmt_user = $conn->prepare($sql_user);
        $stmt_user->bind_param("s", $email);
        $stmt_user->execute();
        $result_user = $stmt_user->get_result();
        $user = $result_user->fetch_assoc();
        $stmt_user->close();

        // Get the current date
        $order_date = date("Y-m-d");

        // Insert the order into the order_booking table
        $sql_order = "INSERT INTO order_booking (name, email, address, contact_number, date, item, price, mop) 
                      VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_order = $conn->prepare($sql_order);
        $stmt_order->bind_param("ssssssss", 
            $user['full_name'], 
            $email, 
            $user['address'], 
            $user['contact_number'], 
            $order_date, 
            $items, 
            $total_price, 
            $paymentMethod
        );
        
        if ($stmt_order->execute()) {
            $redirectUrl = "../../user/user_profile.php";
            // Redirect back to the user profile page
            echo '<script type="text/javascript">';
            echo 'window.location.href = "' . $redirectUrl . '";';
            echo '</script>';
        } else {
            echo "Error: " . $stmt_order->error;
        }

        $stmt_order->close();
    } else {
        echo "Invalid request.";
    }
?>
