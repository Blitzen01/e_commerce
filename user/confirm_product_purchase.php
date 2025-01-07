<?php

    session_start();


    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    
    $email = $_SESSION['email'];
    $email = mysqli_real_escape_string($conn, $email);

    // Get the product ID from the query parameter
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $stock = intval($_GET['quantity']);
        
        // Fetch product details from the database
        $query = "SELECT * FROM products WHERE id = ?";
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
            $sql = "SELECT * FROM products WHERE id = $id";
            $result = mysqli_query($conn, $sql);

            if($result) {
                while($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="container mb-3">
                        <div class="row border rounded p-2">
                            <div class="col-lg-2">
                                <img src="../assets/image/product_image/<?php echo $row['product_image']; ?>" alt="">
                            </div>
                            <div class="col">
                                <h4><?php echo $row['product_name']; ?></h4>
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
             $sql = "SELECT * FROM products WHERE id = $id";
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
                <form action="../assets/php_script/purchase_product_script.php?email=<?php echo $email; ?>&id=<?php echo $id; ?>&quantity=<?php echo $stock; ?>&mop=" 
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