<?php

    session_start();

    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";

    // Get the package ID from the query parameter
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
        // Fetch package details from the database
        $query = "SELECT * FROM package WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $package = $result->fetch_assoc();
        
        if (!$package) {
            echo "package not found.";
            exit;
        }
    } else {
        echo "No package selected.";
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php echo $package['package_name']; ?>
        </title>
        
        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>
    
    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10">
                    <div class="text-center p-2">
                        <!-- package Image -->
                        <img src="../assets/image/package_image/<?php echo $package['package_image']; ?>" alt="package Image" class="image-fluid border shadow fixed-height-image">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-10">
                    <!-- package Details -->
                    <span class="fs-2"><b><?php echo $package['package']; ?></b></span>
                    <span class="fs-5">(<?php echo $package['package_name']; ?>)</span>
                    <p class="text-muted">Price: &#8369; <?php echo number_format($package['package_price'], 2); ?></p>
                    <br><br>
                    <div class="ms-3">
                        <?php
                            if (!empty($_SESSION['email'])) {
                                ?>
                                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#add_package_modal<?php echo $id; ?>">Add to Cart</button>
                                <?php
                            } else {
                                ?>
                                    <a class="btn btn-secondary" href="sign_in.php">Add to Cart</a>
                                <?php
                            }
                        ?>
                        <button 
                            class="btn btn-primary ms-2" 
                            onclick="checkLoginStatusAndShowModal(<?php echo isset($_SESSION['email']) ? 'true' : 'false'; ?>)">
                            Buy Now
                        </button>
                    </div>
                </div>
            </div>
            
            <br>
            <h4>Package Inclusions</h4>
            <table class="table">
                <thead>
                    <th>
                        <td></td>
                        <td></td>
                    </th>
                </thead>
                <tbody>
                    <tr>
                        <td><b>processor</b></td>
                        <td><?php echo $package['processor']; ?></td>
                        <td>&#8369; <?php echo number_format($package['processor_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>ram</b></td>
                        <td><?php echo $package['ram']; ?></td>
                        <td>&#8369; <?php echo number_format($package['ram_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>ssd</b></td>
                        <td><?php echo $package['ssd']; ?></td>
                        <td>&#8369; <?php echo number_format($package['ssd_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>hdd</b></td>
                        <td><?php echo $package['hdd']; ?></td>
                        <td>&#8369; <?php echo number_format($package['hdd_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>monitor</b></td>
                        <td><?php echo $package['monitor']; ?></td>
                        <td>&#8369; <?php echo number_format($package['monitor_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>display</b></td>
                        <td><?php echo $package['display']; ?></td>
                        <td>&#8369; <?php echo number_format($package['display_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>psu</b></td>
                        <td><?php echo $package['psu']; ?></td>
                        <td>&#8369; <?php echo number_format($package['psu_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>keyboard_mouse</b></td>
                        <td><?php echo $package['keyboard_mouse']; ?></td>
                        <td>&#8369; <?php echo number_format($package['keyboard_mouse_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>avr</b></td>
                        <td><?php echo $package['avr']; ?></td>
                        <td>&#8369; <?php echo number_format($package['avr_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>speaker</b></td>
                        <td><?php echo $package['speaker']; ?></td>
                        <td>&#8369; <?php echo number_format($package['speaker_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>processor</b></td>
                        <td><?php echo $package['processor']; ?></td>
                        <td>&#8369; <?php echo number_format($package['processor_price']); ?></td>
                    </tr>
                    <tr>
                        <td><b>CPU only</b></td>
                        <td></td>
                        <td><b>&#8369; <?php echo number_format($package['cpu_only']); ?></b></td>
                    </tr>
                </tbody>
            </table>

            <div class="row mt-5">
                <span class="text-secondary">Other Package</span>
                <?php
                    $sql1 = "SELECT * FROM package WHERE id != $id";
                    // $sql1 = "SELECT * FROM package";

                    $result1 = mysqli_query($conn, $sql1);
                    // $result1 = mysqli_query($conn, $sql1);

                    if($result1) {  //$result && $result1
                        while($row1 = mysqli_fetch_assoc($result1)) {
                            ?>
                            <div class="col-lg-3">
                                <div class="card m-2">
                                    <!-- Image Section -->
                                    <div class="position-relative overflow-hidden d-flex justify-content-center align-items-center" style="height: 200px;">
                                        <img 
                                            src="../assets/image/package_image/<?php echo $row1['package_image']; ?>" 
                                            alt="package Image" 
                                            class="img-fluid w-100 h-100" 
                                            style="object-fit: cover;">
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 opacity-0 hover-overlay">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_to_cart<?php echo $id; ?>">Add to Cart</button>
                                        </div>
                                    </div>

                                    <!-- package Details -->
                                    <div class="card-body">
                                        <?php
                                            $packageName = $row1['package_name'];
                                            if (strlen($packageName) > 35) {
                                                $displayName = substr($packageName, 0, 35) . '...';
                                            } else {
                                                $displayName = $packageName;
                                            }
                                        ?>
                                        <a class="nav-link" href="view_package.php?id=<?php echo $row1['id']; ?>">
                                            <span><b><?php echo $displayName; ?></b> &#8369; <?php echo number_format($row1['package_price'], 2); ?></span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                ?>
            </div>
        </div>


        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            

            // Check login status and show the modal
            function checkLoginStatusAndShowModal(isLoggedIn) {
                if (!isLoggedIn) {
                    // Redirect to login page if not logged in
                    alert("You must be logged in to proceed.");
                    window.location.href = "sign_in.php";
                } else {
                    // Show the Bootstrap modal
                    const modalElement = document.getElementById("package_buy_now");
                    const modal = new bootstrap.Modal(modalElement);
                    modal.show();
                }
            }

            // Adjust the quantity in the modal
            function adjustQuantity(change, maxQuantity) {
                const quantityInput = document.getElementById("quantityInput");
                const confirmPurchaseLink = document.getElementById("confirmPurchaseLink");
                let currentQuantity = parseInt(quantityInput.value);
                let newQuantity = currentQuantity + change;

                if (newQuantity > 0 && newQuantity <= maxQuantity) {
                    quantityInput.value = newQuantity;
                    // Update the href with the new quantity
                    const baseHref = confirmPurchaseLink.href.split('&quantity=')[0];
                    confirmPurchaseLink.href = `${baseHref}&quantity=${newQuantity}`;
                } else if (newQuantity > maxQuantity) {
                    alert("You cannot select more than the available stock.");
                }
            }
        </script>
    </body>
</html>


<!-- Modal for Buy Now -->
<div class="modal fade" id="package_buy_now" tabindex="-1" aria-labelledby="package_buy_now_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="package_buy_now_label"><?php echo $package['package']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="../assets/image/package_image/<?php echo $package['package_image']; ?>" alt="Package Image" class="img-fluid mb-3 p-2 border shadow" style="max-height: 200px;">
                </div>
                <p class="text-muted text-center">Price: &#8369; <?php echo number_format($package['package_price'], 2); ?></p>
                <div class="d-flex justify-content-center align-items-center">
                    <button class="btn btn-outline-secondary me-2" onclick="adjustQuantity(-1, <?php echo $package['stocks']; ?>)">-</button>
                    <input type="text" id="quantityInput" class="form-control text-center" value="1" style="width: 60px;" readonly>
                    <button class="btn btn-outline-secondary ms-2" onclick="adjustQuantity(1, <?php echo $package['stocks']; ?>)">+</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id="confirmPurchaseLink" href="confirm_package_purchase.php?id=<?php echo $package['id']; ?>&quantity=1">Confirm Purchase</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Buy Now -->