<!-- Add Product Modal -->
<div class="modal fade" id="add_product_modal" tabindex="-1" aria-labelledby="add_product_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="add_product_modal_label">Add Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../assets/php_script/add_product_script.php" method="post" enctype="multipart/form-data">
                    <select name="product_category" id="product_category" class="form-select mb-3">
                        <option value="default" disabled>Default</option>
                        <?php
                            $sql = "SELECT * FROM product_category";
                            $result = mysqli_query($conn, $sql);

                            if($result) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                        <option value="<?php echo $row['category']; ?>"><?php echo $row['category']; ?></option>
                                    <?php
                                }
                            }
                        ?>
                    </select>

                    <!-- Image upload input -->
                    <div class="mb-3">
                        <label for="product_image">Product Image</label>
                        <input type="file" class="form-control" name="product_image" id="product_image" accept="image/*">
                    </div>

                    <div class="mb-3">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" autocomplete="off">
                    </div>
                    
                    <div class="mb-3">
                        <label for="product_price">Price</label>
                        <input type="text" class="form-control" name="product_price" id="product_price" autocomplete="off">
                    </div>
                    
                    <div class="mb-2">
                        <label for="product_stocks">Stocks</label>
                        <input type="text" class="form-control" name="product_stocks" id="product_stocks" autocomplete="off">
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
<!-- Add Product Modal -->

<!-- Update Product Modal -->
<div class="modal fade" id="update_product_modal" tabindex="-1" aria-labelledby="update_product_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="update_product_modal_label">Update Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="../../assets/php_script/update_product_script.php" method="post">
                    <input type="hidden" name="product_id" id="product_id">
                    <input type="hidden" name="product_category" id="product_category">
                    <div class="mb-3">
                        <label for="product_name">Product Name</label>
                        <input type="text" class="form-control" name="product_name" id="product_name" autocomplete="off">
                    </div>
                    <div class="mb-3">
                        <label for="product_price">Price</label>
                        <input type="number" class="form-control" name="product_price" id="product_price" autocomplete="off">
                    </div>
                    <div class="mb-2">
                        <label for="product_stocks">Stocks</label>
                        <input type="number" class="form-control" name="product_stocks" id="product_stocks" autocomplete="off">
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Update Product Modal -->

<!-- Delete Product Modal -->
<div class="modal fade" id="delete_product_modal" tabindex="-1" aria-labelledby="delete_product_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="delete_product_modal_label">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this product?</p>
                <form action="../../assets/php_script/delete_product_script.php" method="post">
                    <!-- Hidden field to store the product ID -->
                    <input type="hidden" name="product_id" id="delete_product_id">
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Delete Product Modal -->

<!-- Create Scheduled Booking Modal -->
<div class="modal fade" id="create_scheduled_booking" tabindex="-1" aria-labelledby="create_scheduled_booking_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="create_scheduled_booking_label">Create Booking</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                    $email = $_SESSION['email'];
                ?>
                <form method="POST" action="../assets/php_script/scheduled_booking.php"> <!-- Add your form action URL -->
                    <div class="mb-3">
                        <label for="type_of_booking">Type of Booking</label>
                        <select name="type_of_booking" id="type_of_booking" class="form-select">
                            <option value="Laptop Repair">Laptop Repair</option>
                            <option value="CPU Repair">CPU Repair</option>
                            <option value="CCTV Installation">CCTV Installation</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="dateInput">Select Date</label>
                        <input type="date" class="form-control" id="dateInput" name="dateInput" required>
                    </div>
                    <div class="form-group">
                        <label for="timeInput">Select Time</label>
                        <input type="time" class="form-control" id="timeInput" name="timeInput" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Create Scheduled Booking Modal -->

<!-- Log out modal -->
<div class="modal fade" id="log_out_modal" tabindex="-1" aria-labelledby="log_out_modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-secondary text-light">
                <h5 class="modal-title" id="log_out_modal_label">Log Out</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to Log Out?</p>
            </div>
            <div class="modal-footer">
                <a class="btn btn-danger" href="../assets/php_script/user_log_out_script.php">Yes</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<!-- Log out modal -->

<!-- product add to cart Modal -->
<?php
    $sql = "SELECT * FROM products";
    // $sql1 = "SELECT * FROM package";

    $result = mysqli_query($conn, $sql);
    // $result1 = mysqli_query($conn, $sql1);

    if($result) {  //$result && $result1
        while($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="modal fade" id="add_to_cart<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="add_to_cart<?php echo $row['id']; ?>_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="add_to_cart<?php echo $row['id']; ?>_label">Are you sure you want to add this product ?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../assets/php_script/product_add_to_cart_script.php" method="post">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <img 
                                        src="../assets/image/product_image/<?php echo $row['product_image']; ?>" 
                                        alt="Product Image" 
                                        class="img-fluid w-50 h-50 border shadow" 
                                        style="object-fit: cover;">
                                </div>
                                <h5><?php echo $row['product_name']; ?> <span> &#8369;<?php echo number_format($row['price'], 2); ?></span></h5>
                                <input type="hidden" name="product_name" value="<?php echo $row['product_name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $row['price']; ?>">
                                <label for="add_to_cart_product_quantity">Quantity</label>
                                <?php
                                    $stock = $row['stocks'];
                                    if ($stock > 0) {
                                        echo '<select name="quantity" id="add_to_cart_product_quantity" class="form-select">';
                                        for ($i = 1; $i <= $stock; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        echo '</select>';
                                    } else {
                                        echo '<p class="text-danger">Out of stock</p>';
                                    }
                                ?>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cart-plus"></i> Add to cart</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
?>
<!-- product add to cart Modal -->

<!-- package add to cart modal -->
<?php
    $sql = "SELECT * FROM package";
    // $sql1 = "SELECT * FROM package";

    $result = mysqli_query($conn, $sql);
    // $result1 = mysqli_query($conn, $sql1);

    if($result) {  //$result && $result1
        while($row = mysqli_fetch_assoc($result)) {
            ?>
            <div class="modal fade" id="add_package_modal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="add_package_modal<?php echo $row['id']; ?>_label" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="add_package_modal<?php echo $row['id']; ?>_label">Are you sure you want to add this package ?</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="../assets/php_script/product_add_to_cart_script.php" method="post">
                                <div class="d-flex justify-content-center align-items-center mb-2">
                                    <img 
                                        src="../assets/image/package_image/<?php echo $row['package_image']; ?>" 
                                        alt="Package Image" 
                                        class="img-fluid w-50 h-50 border shadow" 
                                        style="object-fit: cover;">
                                </div>
                                <h5><?php echo $row['package_name']; ?> <span> &#8369;<?php echo number_format($row['package_price'], 2); ?></span></h5>
                                <input type="hidden" name="package_name" value="<?php echo $row['package_name']; ?>">
                                <input type="hidden" name="package_price" value="<?php echo $row['package_price']; ?>">
                                <label for="add_to_cart_product_quantity">Quantity</label>
                                <?php
                                    $stock = $row['stocks'];
                                    if ($stock > 0) {
                                        echo '<select name="quantity" id="add_to_cart_product_quantity" class="form-select">';
                                        for ($i = 1; $i <= $stock; $i++) {
                                            echo "<option value='$i'>$i</option>";
                                        }
                                        echo '</select>';
                                    } else {
                                        echo '<p class="text-danger">Out of stock</p>';
                                    }
                                ?>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-cart-plus"></i> Add to cart</button>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
?>
<!-- package add to cart modal -->

<!-- add staff Modal -->
<div class="modal fade" id="add_staff" tabindex="-1" aria-labelledby="add_staff_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="add_staff_label">Add Staff</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../../assets/php_script/add_staff_script.php" method="POST">
            <div class="mb-3">
                <label for="staff_first_name">First Name:</label>
                <input class="form-control" id="staff_first_name" type="text" name="staff_first_name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="staff_last_name">Last Name:</label>
                <input class="form-control" id="staff_last_name" type="text" name="staff_last_name" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="staff_username">Username:</label>
                <input class="form-control" id="staff_username" type="text" name="staff_username" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="staff_contact_number">Contact Number:</label>
                <input class="form-control" id="staff_contact_number" type="text" name="staff_contact_number" autocomplete="off">
            </div>
            <div class="mb-3">
                <label for="staff_position">Position:</label>
                <select name="staff_position" id="staff_position" class="form-select">
                    <option value="Default" disabled readonly>Default</option>
                    <option value="Admin">Admin</option>
                    <option value="Cashier">Cashier</option>
                    <option value="Technician">Technician</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Add</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- add staff Modal -->

<!-- remove staff Modal -->
<div class="modal fade" id="remove_staff" tabindex="-1" aria-labelledby="remove_staff_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="remove_staff_label">Remove Staff</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../../assets/php_script/remove_staff_script.php" method="post">
            <div class="mb-3">
                <label for="remove_staff">Select Staff</label>
                <select name="remove_staff" id="remove_staff" class="form-select">
                    <?php
                        $sql = "SELECT * FROM admin_account";
                        $result = mysqli_query($conn, $sql);

                        if($result) {
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <option value="<?php echo $row['id'];?>"><?php echo $row['first_name'];?> <?php echo $row['last_name'];?></option>
                                <?php
                            }
                        }
                    ?>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Remove</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- remove staff Modal -->