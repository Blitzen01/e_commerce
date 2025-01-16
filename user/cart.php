<?php
    session_start();
    
    if (!isset($_SESSION['email'])) {
        header("Location: sign_in.php");
    }

    $email = $_SESSION['email'];
    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cart</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>
        <?php include "chat.php"; ?>

        <div class="m-3">
            <div class="container">
                <div class="ms-3">
                    <button class="btn text-primary" data-bs-toggle="modal" data-bs-target="#add_billing_address"><small>ADD NEW BILLING ADDRESS</small></button>
                    <button class="btn text-secondary" data-bs-toggle="modal" data-bs-target="#change_billing_address"><small>CHANGE BILLING ADDRESS</small></button>
                </div>
                <div class="card p-2">
                    <?php
                        $sql = "SELECT * FROM user_account WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);

                        if ($result) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <span><b><?php echo $row["full_name"]; ?></b> (<?php echo $row["contact_number"]; ?>)</span>
                                <span><?php echo $row["address"]; ?></span>
                                <?php
                            }
                        }
                    ?>
                </div>

                <form id="checkoutForm" action="../assets/php_script/check_out_order.php" method="post">
                    <?php
                    $sql = "
                        SELECT pc.*, p.product_image, p.product_name AS prod_name, pk.package_image 
                        FROM product_cart pc
                        LEFT JOIN products p ON pc.product_name = p.product_name
                        LEFT JOIN package pk ON pc.product_name = pk.package_name
                        WHERE pc.email = '$email'
                    ";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $imagePath = !empty($row['product_image']) 
                                ? "../assets/image/product_image/{$row['product_image']}" 
                                : (!empty($row['package_image']) 
                                    ? "../assets/image/package_image/{$row['package_image']}" 
                                    : "../assets/image/placeholder.png");
                            ?>
                            <div class="form-check border p-1 my-3">
                                <div class="row">
                                    <div class="col-lg-1 col-sm-1 d-flex align-items-center justify-content-center">
                                        <input 
                                            class="form-check-input product-checkbox" 
                                            type="checkbox" 
                                            value="<?php echo $row['id']; ?>" 
                                            data-name="<?php echo $row['product_name']; ?>"
                                            data-price="<?php echo $row['total_price']; ?>" 
                                            id="product-<?php echo $row['id']; ?>" 
                                            name="product_id[]">
                                    </div>
                                    <div class="col-lg-1 col-sm-1">
                                        <img src="<?php echo $imagePath; ?>" 
                                            alt="Product Image" 
                                            class="img-fluid w-100 h-100" 
                                            style="object-fit: cover;">
                                    </div>
                                    <div class="col">
                                        <span><b><?php echo $row["product_name"]; ?></b></span>
                                        <br>
                                        <span>&#8369; <?php echo $row["total_price"] / $row["quantity"]; ?> <b>x<?php echo $row["quantity"]; ?></b></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <select name="mop" id="mop" class="form-select w-25 mt-3" required>
                        <option value="cod">Cash on Delivery</option>
                        <option value="otc">Over the Counter</option>
                    </select>
                    <div class="text-end">
                        <h3 id="cart-total" class="mb-3">Total: &#8369; 0</h3>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewProductsModal">
                            View Products
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteItemsModal">Delete</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const checkboxes = document.querySelectorAll(".product-checkbox");
                const totalDisplay = document.getElementById("cart-total");
                const viewProductsList = document.getElementById("viewProductsList");

                // Function to update the total price
                function updateTotal() {
                    let total = 0;
                    checkboxes.forEach((checkbox) => {
                        if (checkbox.checked) {
                            total += parseFloat(checkbox.dataset.price);
                        }
                    });
                    totalDisplay.textContent = `Total: ₱ ${total.toFixed(2)}`;
                }

                // Function to update the modal with selected products
                function updateViewModal() {
                    viewProductsList.innerHTML = ""; // Clear previous content
                    checkboxes.forEach((checkbox) => {
                        if (checkbox.checked) {
                            const name = checkbox.dataset.name;
                            const price = parseFloat(checkbox.dataset.price).toFixed(2); // Format price
                            const productRow = checkbox.closest(".row"); // Find the parent row
                            const imageElement = productRow.querySelector("img"); // Get the image element
                            const imageSrc = imageElement ? imageElement.src : "../assets/image/placeholder.png";

                            // Create a container for each product
                            const productContainer = document.createElement("div");
                            productContainer.classList.add("d-flex", "align-items-center", "mb-3");

                            // Create the image element for the modal
                            const productImage = document.createElement("img");
                            productImage.src = imageSrc;
                            productImage.alt = name;
                            productImage.style.width = "50px";
                            productImage.style.height = "50px";
                            productImage.style.objectFit = "cover";
                            productImage.classList.add("me-3");

                            // Create the text element for the name and price
                            const productText = document.createElement("span");
                            productText.textContent = `${name} - Price: ₱${price}`;

                            // Append the image and text to the container
                            productContainer.appendChild(productImage);
                            productContainer.appendChild(productText);

                            // Append the container to the modal body
                            viewProductsList.appendChild(productContainer);
                        }
                    });
                }

                // Attach event listeners to update total and modal content
                checkboxes.forEach((checkbox) => {
                    checkbox.addEventListener("change", updateTotal);
                });

                document
                    .querySelector("button[data-bs-target='#viewProductsModal']")
                    .addEventListener("click", updateViewModal);
            });
        </script>
    </body>
</html>

<div class="modal fade" id="viewProductsModal" tabindex="-1" aria-labelledby="viewProductsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewProductsModalLabel">Selected Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <ul id="viewProductsList"></ul>
            </div>
            <div class="modal-footer">
                <button type="submit" form="checkoutForm" class="btn btn-success">Proceed to Checkout</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- change address -->
<div class="modal fade" id="change_billing_address" tabindex="-1" aria-labelledby="change_billing_address_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="change_billing_address_label">Change Billing Address</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../assets/php_script/set_default_address.php" method="post">
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