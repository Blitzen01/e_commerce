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
                <div class="card p-2">
                    <?php
                        $sql = "SELECT * FROM user_account WHERE email = '$email'";
                        $result = mysqli_query($conn, $sql);

                        if($result) {
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <span><b><?php echo $row["full_name"]; ?></b> (<?php echo $row["contact_number"]; ?>)</span>
                                <span><?php echo $row["address"]; ?></span>
                                <?php
                            }
                        }
                    ?>
                </div>

                <form action="../assets/php_script/check_out_order.php" method="post">
                    <?php
                    $sql = "SELECT * FROM product_cart WHERE email = '$email'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="form-check border p-1 my-3">
                                <div class="row">
                                    <!-- Checkbox Column -->
                                    <div class="col-lg-1 col-sm-1 d-flex align-items-center justify-content-center">
                                        <input 
                                            class="form-check-input product-checkbox" 
                                            type="checkbox" 
                                            value="<?php echo $row['id']; ?>" 
                                            data-name="<?php echo $row['product_name']; ?>"
                                            data-price="<?php echo $row['total_price']; ?>" 
                                            id="flexCheckChecked_<?php echo $row['id']; ?>">
                                    </div>
                                    <!-- Image Column -->
                                    <div class="col-lg-1 col-sm-1">
                                        <?php
                                        $product_name = $row["product_name"];
                                        $sql1 = "SELECT * FROM products WHERE product_name = '$product_name'";
                                        $result1 = mysqli_query($conn, $sql1);

                                        if ($result1) {
                                            while ($row1 = mysqli_fetch_assoc($result1)) {
                                                ?>
                                                <img src="../assets/image/product_image/<?php echo $row1['product_image']; ?>" 
                                                    alt="Product Image" 
                                                    class="img-fluid w-100 h-100" 
                                                    style="object-fit: cover;">
                                                <?php
                                            }
                                        }
                                        ?>
                                    </div>
                                    <!-- Product Details Column -->
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
                        <input type="hidden" name="product_ids[]" id="product_ids">
                        <h3 id="cart-total" class="mb-3">Total: &#8369; 0</h3>
                        <!-- Button to trigger modal -->
                        <button type="submit" class="btn btn-primary">
                            Check Out
                        </button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#deleteItemsModal">Delete</button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            document.addEventListener("DOMContentLoaded", () => {
                const checkboxes = document.querySelectorAll(".product-checkbox");
                const totalDisplay = document.getElementById("cart-total");

                // Function to update the total price based on selected checkboxes
                function updateTotal() {
                    let total = 0;
                    checkboxes.forEach((checkbox) => {
                        if (checkbox.checked) {
                            total += parseFloat(checkbox.dataset.price);
                        }
                    });
                    totalDisplay.textContent = `Total: ₱ ${total.toFixed(2)}`;
                }

                // Attach event listeners to all checkboxes
                checkboxes.forEach((checkbox) => {
                    checkbox.addEventListener("change", () => {
                        // Uncheck all checkboxes except the one clicked
                        checkboxes.forEach((otherCheckbox) => {
                            if (otherCheckbox !== checkbox) {
                                otherCheckbox.checked = false;
                            }
                        });
                        updateTotal(); // Update the total whenever a checkbox is changed
                    });
                });
            });


            document.querySelector('form').addEventListener('submit', function (e) {
                const selectedCheckboxes = document.querySelectorAll('.product-checkbox:checked');
                const productIds = [];
                selectedCheckboxes.forEach(checkbox => productIds.push(checkbox.value));
                document.getElementById('product_ids').value = JSON.stringify(productIds);
            });

            document.addEventListener("DOMContentLoaded", () => {
                const deleteButton = document.querySelector("button[data-bs-target='#deleteItemsModal']");
                const checkboxes = document.querySelectorAll(".product-checkbox");
                const deleteItemsList = document.getElementById("deleteItemsList");
                const deleteIdsInput = document.getElementById("deleteIds");

                // Function to update modal content and store selected IDs
                function updateDeleteModal() {
                    deleteItemsList.innerHTML = ""; // Clear previous list
                    const selectedIds = []; // Array to store selected IDs

                    checkboxes.forEach((checkbox) => {
                        if (checkbox.checked) {
                            const name = checkbox.dataset.name;
                            const id = checkbox.value;

                            // Add item name to the modal list
                            const listItem = document.createElement("li");
                            listItem.textContent = name;
                            deleteItemsList.appendChild(listItem);

                            // Add ID to the array
                            selectedIds.push(id);
                        }
                    });

                    // Store selected IDs in the hidden input
                    deleteIdsInput.value = JSON.stringify(selectedIds);
                }

                // Update modal content when the delete button is clicked
                deleteButton.addEventListener("click", updateDeleteModal);
            });
        </script>
    </body>
</html>

<div class="modal fade" id="deleteItemsModal" tabindex="-1" aria-labelledby="deleteItemsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteItemsModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="deleteForm" action="../assets/php_script/cart_delete_items.php" method="POST">
                <div class="modal-body">
                    <p>The following items will be deleted:</p>
                    <ul id="deleteItemsList"></ul>
                    <!-- Hidden input to store selected IDs -->
                    <input type="hidden" name="delete_ids" id="deleteIds">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Confirm Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>