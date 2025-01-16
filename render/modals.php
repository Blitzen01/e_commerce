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
                            <option value="Repair">Repair</option>
                            <option value="Parts Installation">Parts Installation</option>
                            <option value="CCTV Repair">CCTV</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="kind_of_booking">What kind of repair, installation, CCTV concern ?</label>
                        <select name="kind_of_booking" id="kind_of_booking" class="form-select">
                            <option value="Laptop Repair">Laptop Repair: &#8369;800</option>
                            <option value="Desktop Repair">CPU Repair: &#8369;700</option>
                            <option value="CCTV Repair">CCTV Repair: &#8369;550</option>
                            <option value="Board Level">Board Level: &#8369;2500(Min. Charge)</option>
                            <option value="Laptop Installation">Laptop Installation: &#8369;250</option>
                            <option value="Desktop Installation">Desktop Installation: &#8369;200</option>
                            <option value="Printer">Printer: &#8369;150</option>
                            <option value="CCTV Walk In">CCTV Walk In: &#8369;400</option>
                            <option value="CCTV On Site">CCTV On Site: &#8369;800</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="dateInput">Select Date</label>
                        <input type="date" class="form-control" id="dateInput" name="dateInput" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="timeInput">Select Time</label>
                        <input type="time" class="form-control" id="timeInput" name="timeInput" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="mob">Mode of Booking</label>
                        <select class="form-select" name="mob" id="mob" required>
                            <option value="Walk In">Walk In</option>
                            <option value="On Site">On Site</option>
                        </select>
                    </div>
                    <div class=" mb-3">
                        <label for="remarks">Remarks</label>
                        <textarea type="text" class="form-control" row="15" id="remarks" name="remarks" placeholder="Leave a your remarks here" required></textarea>
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-text">
                            <input class="form-check-input mt-0" type="checkbox" value="" aria-label="Checkbox for following text input" required>
                        </div>
                        <small class="ms-2">Accept Terms and Conditions. <button class="btn bg-light text-primary fs-small" onclick="showWarranty()";>Show warranty</button></small>
                    </div>
                    <!-- warranty display -->
                    <small id="show_warranty" style="display: none;">
                        WARRANTY:
                            1. HFA provides a 30 days warranty on labor only repairs carried out on computer equipment requested by the client. 
                            HFA makes no warranty for data or computer files either expressed or implied. HFA DISCLAIMS any data warranty of any kind. 
                            If the same problem re-occurs within 30 days of the original repair, HFA will undertake the repair again without charge. However, 
                            charges will be incurred if additional parts are required. This warranty includes faults caused by viruses or software issues.
                            <br>
                            2. All parts supplied by HFA are new and come with a 1-year manufacturer's warranty from the date of repair. In some instances, 
                            we may offer second hand or used parts at a reduced cost. The client will be consulted if they are willing to accept second hand or 
                            used parts prior to fitting. No warranty will be provided with second hand or used parts.
                            <br>
                            3. Any warranty offered will become invalid if the manufacturer's marked label is removed or tampered with in any way from the parts 
                            installed during a repair.
                            <br>
                            4. Parts are only covered under warranty that fail dure to manufacturing defects for the said parts and confirmed by the component manufacturer. 
                            Should the part fail because of mishandling of the computer equipment or inadequate subsequent servicing or failure from 
                            "fair wear and tear" the warranty becomes invalid.
                            <br>
                            5. Damage to a computer system or its components supplied by HFA under a repair contract caused by a power surge or spikes, including 
                            but not limited to main power and telecoms connections or other unspecified sources e.g., voltage fluctuation, amperage fluctuation, water 
                            ingress are not covered under the warranty.
                            <br>
                            6. Furthermore, the warranty does not cover for any loss or damage due to negligence, mishandling, accidents, theft, 
                            water flooding, war outbreak, electrical storms, fire outbreak, earthquakes, or any other act of environment.
                            <br>
                            7. HFA only perform and provide computer services, repairs, and upgrades as requested by the customer. HFA will conduct honest, 
                            reasonable, and considerate services. The goals to is to provide the highest quality of service and support, but specific results 
                            cannot be guaranteed. Computer service/repairs are provided as a service. There are many be circumstances under which your computer 
                            can not be repaired. It will have to be rebuilt or upgraded. Examples: Age of PC, repair/replacement parts obsolete 
                            (memory chips, motherboards, etc.) The length of time required to service/repair your computer cannot be predicted. 
                            You understand that in the process of working on your computer equipment, there is a potential for data loss. You agree that you have 
                            make the necessary backups of your data so that, in the event of such loss, the data can be restored. HFA will not be responsible for data loss.
                            <br>
                            8. Customer satisfaction is our utmost importance. All services will be conducted in a professional, reasonable and timely manner. 
                            Also, taking into consideration the circumstances and nature of the technical problems.
                            <br>
                            <span class="text-danger">
                                9. HFA will charge client 30 per day storage fee for all units not claim within 90 days. Unclaimed units will dispose after the noticed.
                            </span>
                    </small>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        function showWarranty() {
            // Get the element with id "show_warranty"
            var warrantyElement = document.getElementById("show_warranty");
            
            // Toggle the display property
            if (warrantyElement.style.display === "none") {
                warrantyElement.style.display = "inline";  // Show the warranty message
            } else {
                warrantyElement.style.display = "none";  // Hide the warranty message
            }
        }
    </script>
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
                                <input type="hidden" name="product_name" value="<?php echo $row['package_name']; ?>">
                                <input type="hidden" name="price" value="<?php echo $row['package_price']; ?>">
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
                <label for="staff_email">Email:</label>
                <input class="form-control" id="staff_email" type="email" name="staff_email" autocomplete="off">
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
        <h1 class="modal-title fs-5" id="remove_staff_label">Archive Staff</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../../assets/php_script/remove_staff_script.php" method="post">
          <div class="mb-3">
            <label for="remove_staff">Select Staff</label>
            <select name="remove_staff" id="remove_staff" class="form-select">
              <?php
                session_start();
                $email = $_SESSION['admin_email'];
                $role = "";
                $sql = "SELECT * FROM admin_account WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                if($result) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $role = $row['role'];
                    }
                }
                $sql = "SELECT * FROM admin_account";
                $result = mysqli_query($conn, $sql);

                if ($result) {
                  while ($row = mysqli_fetch_assoc($result)) {
                    // If the role is 'admin', exclude other admins
                    if ($role === 'Admin' && $row['role'] === 'Admin') {
                      continue; // Skip this iteration
                    }
                    ?>
                    <option value="<?php echo $row['id']; ?>">
                      <?php echo $row['first_name'] . ' ' . $row['last_name'] . ' (' . $row['role'] . ')'; ?>
                    </option>
                    <?php
                  }
                }
              ?>
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Archive</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- remove staff Modal -->

<!-- Add Billing Address Modal -->
<div class="modal fade" id="add_billing_address" tabindex="-1" aria-labelledby="add_billing_address_label" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="add_billing_address_label">Add Billing Address</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="billingAddressForm" action="../assets/php_script/add_billing_address.php" method="POST">
          <div class="mb-3">
            <label for="fullName" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullName" name="full_name" required>
          </div>
          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>
          <div class="mb-3">
            <label for="contactNumber" class="form-label">Contact Number</label>
            <input type="text" class="form-control" id="contactNumber" name="contact_number" required>
          </div>
          <div class="form-check">
            <input type="checkbox" class="form-check-input" id="defaultAddress" name="default_address" value="1">
            <label class="form-check-label" for="defaultAddress">Set as Default Address</label>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save Address</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Add Billing Address Modal -->