<?php
    session_start();
    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";

    // Fetch the parts selected from the form submission
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $parts = $_POST['parts_name'];
    } else {
        echo "No parts selected.";
        exit;
    }

    // Get the user email and other session info
    $email = $_SESSION['email'];
    $is_new = 1;

    if (isset($email)) {
        $stmt = $conn->prepare("SELECT is_new FROM user_account WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($is_new);
        $stmt->fetch();
        $stmt->close();
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Order Review</title>
        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>

    <body>
        <div class="container">
            <h4 class="text-center">Review Your Custom PC Order</h4>
            <div class="ms-3">
                <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#add_billing_address"><small>ADD NEW BILLING ADDRESS</small></button>
                <button class="btn text-secondary" data-bs-toggle="modal" data-bs-target="#change_billing_address"><small>CHANGE BILLING ADDRESS</small></button>
            </div>
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
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Parts Category</th>
                        <th>Parts Name</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach ($parts as $category => $part_name) {
                            if (!empty($part_name)) {
                                // Query to fetch the part price and image URL
                                $sql_parts = "SELECT price, image FROM computer_parts WHERE parts_name = ?";
                                $stmt = $conn->prepare($sql_parts);
                                $stmt->bind_param("s", $part_name);
                                $stmt->execute();
                                $stmt->bind_result($price, $image_url);
                                $stmt->fetch();
                                $stmt->close();

                                // Display the part details along with the image
                                echo "<tr>
                                        <td><img src='../assets/image/computer_parts_image/" . htmlspecialchars($image_url) . "' alt='' style='width: 100px; height: auto;'></td>
                                        <td>" . htmlspecialchars($category) . "</td>
                                        <td>" . htmlspecialchars($part_name) . "</td>
                                        <td>₱" . number_format($price, 2) . "</td>
                                    </tr>";
                            }
                        }
                    ?>
                </tbody>
            </table>

            <div>
                <form action="../assets/php_script/place_custom_parts_script.php" method="post">
                    <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
                    <input type="hidden" name="parts" value="<?php echo htmlspecialchars(json_encode($parts)); ?>">

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
                    <div class="mb-3 text-end">
                        <button type="submit" class="btn btn-primary">Place Order</button>
                    </div>
                </form>
            </div>
        </div>

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