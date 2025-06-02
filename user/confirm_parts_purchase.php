<?php
    session_start();

    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";
    
    $email = $_SESSION['email'];
    $email = mysqli_real_escape_string($conn, $email);

    // Get the product ID from the query parameter
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stock = intval($_GET['quantity']);
        
        // Fetch product details from the database
        $query = "SELECT * FROM computer_parts WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        
        if (!$product) {
            echo "Product not found.";
            exit;
        }
    } else {
        echo "No product selected.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">

        <style>
            
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>
        <?php include "chat.php"; ?>

        <?php
            $sql1 = "SELECT * FROM user_account WHERE email = '$email'";
            $result1 = mysqli_query($conn, $sql1);

            if($result1) {
                while($user = mysqli_fetch_assoc($result1)) {
                    ?>
                    <div class="container mb-3">
                        <div class="row border rounded p-2">
                            <span><b><?php echo $user['full_name']; ?></b> (<?php echo $user['contact_number']; ?>)</span>
                            <span><?php echo $user['address']; ?></span>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>

        <?php
            $sql = "SELECT * FROM computer_parts WHERE id = $id";
            $result = mysqli_query($conn, $sql);

            if($result) {
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="container mb-3">
                        <div class="ms-3">
                            <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#add_billing_address"><small>ADD NEW BILLING ADDRESS</small></button>
                            <button class="btn text-secondary" data-bs-toggle="modal" data-bs-target="#change_billing_address"><small>CHANGE BILLING ADDRESS</small></button>
                        </div>
                        <div class="row border rounded p-2">
                            <div class="col-lg-2">
                                <img src="../assets/image/computer_parts_image/<?php echo $row['image']; ?>" alt="">
                            </div>
                            <div class="col">
                                <h4><?php echo $row['parts_name']; ?></h4>
                                <span class="me-5">Price: <?php echo $row['price']; ?></span>
                                <span>Quantity: <?php echo $stock; ?></span>
                            </div>
                        </div>
                    </div>
                    <?php
                }
            }
        ?>

        <div class="container mb-3">
            <?php
             $sql = "SELECT * FROM computer_parts WHERE id = $id";
             $result = mysqli_query($conn, $sql);
 
             if($result) {
                 while($row = mysqli_fetch_assoc($result)) {
                     ?>
                    <div class="row border rounded p-2">
                        <span><b>Payment Details</b></span>
                        <span>Price:  &#8369;<?php echo $row['price'];?></span>
                        <span>Quantity: <?php echo $stock;;?></span>
                        <span>Total:  &#8369;<?php echo $row['price']*$stock;?></span>
                    </div>
                <?php
                    }
                }
            ?>
        </div>

        <div class="container">
                <form action="../assets/php_script/purchase_parts_script.php?email=<?php echo $email; ?>&id=<?php echo $id; ?>&quantity=<?php echo $stock; ?>&mop=" 
                        method="post" id="purchaseForm">
                    <div class="row border rounded p-2 mb-3">
                        <span><b>Payment Method</b></span>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="cod" value="cod" checked>
                            <label class="form-check-label" for="cod">
                                Cash on Delivery (COD)
                            </label>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="paymentMethod" id="otc" value="otc">
                            <label class="form-check-label" for="otc">
                                Over the Counter (OTC)
                            </label>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-primary" type="submit" onclick="updateFormAction()">Place Order</button>
                    </div>
                </form>
        </div>
        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            function updateFormAction() {
                // Get the selected payment method
                const selectedMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

                // Update the form's action attribute
                const form = document.getElementById('purchaseForm');
                const currentAction = form.action;

                // Append the selected payment method to the 'mop' parameter in the action URL
                form.action = currentAction.replace(/&mop=/, `&mop=${selectedMethod}`);
            }
        </script>
    </body>
</html>

<!-- change address -->
<div class="modal fade" id="change_billing_address" tabindex="-1" aria-labelledby="change_billing_address_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="change_billing_address_label">Change Billing Address</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../assets/php_script/set_default_address_product.php?id=<?php echo $id;?>&quantity=<?php echo $stock;?>" method="post">
                <?php
                    // Assuming the email is stored in the session
                    $email = $_SESSION['email'];
                    $user_id = "";

                    // Fetch user ID based on email
                    $sqlUser = "SELECT id FROM user_account WHERE email = ?";
                    $stmtUser = $conn->prepare($sqlUser);
                    $stmtUser->bind_param("s", $email);
                    $stmtUser->execute();
                    $resultUser = $stmtUser->get_result();
                    if ($resultUser->num_rows > 0) {
                        $row = $resultUser->fetch_assoc();
                        $user_id = $row['id'];
                    } else {
                        echo "User not found.";
                        exit;
                    }
                    $stmtUser->close();

                    // Fetch billing addresses for the user
                    $sqlBilling = "SELECT * FROM billing_address WHERE user_id = ?";
                    $stmtBilling = $conn->prepare($sqlBilling);
                    $stmtBilling->bind_param("i", $user_id);
                    $stmtBilling->execute();
                    $resultBilling = $stmtBilling->get_result();

                    // Display billing addresses
                    if ($resultBilling->num_rows > 0) {
                        while ($row = $resultBilling->fetch_assoc()) {
                            $checked = $row['default_address'] ? "checked" : "";
                            echo "<div class='mb-3'>
                                    <input type='radio' name='billing_address' value='{$row['id']}' $checked>
                                    <b>" . htmlspecialchars($row['full_name']) . "</b> (" . htmlspecialchars($row['contact_number']) . ")<br>
                                    " . htmlspecialchars($row['address']) . "
                                </div>";
                        }
                    } else {
                        echo "<li>No billing addresses found.</li>";
                    }

                    $stmtBilling->close();
                ?>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="saveDefaultAddress">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- change address -->