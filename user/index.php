<?php
    session_start();

    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";

    // Get search query from URL parameters if present
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
    $carouselStyle = !empty($searchQuery) ? 'display: none;' : '';

    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email'];
    }
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

<!-- Modal -->
<div class="modal fade" id="is_new_account" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Fill up form to proceed</h1>
            </div>
            <div class="modal-body">
                <form action="../assets/php_script/first_update_profile_script.php" method="post" id="newAccountForm">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" readonly required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirm_password" required>
                        <div class="invalid-feedback">
                            Passwords do not match.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="mb-3">
                        <label for="contactNumber" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contactNumber" name="contact_number" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">

        <style>
            .modal-dialog {
                max-height: calc(100% - 1rem); /* Ensures the modal does not overflow the viewport */
                overflow-y: auto; /* Enables vertical scrolling within the modal */
            }

            .modal-body {
                max-height: 70vh; /* Adjust as needed */
                overflow-y: auto; /* Ensures the scroll is inside the modal body */
            }
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>
        <?php include "chat.php"; ?>

        <?php include "web_content/carousel.php"; ?>

        <div class="container" id="best_selling">
            <h3><b>Top Best-Selling Products</b></h3>
            <div class="row">
                <?php
                    // Query to get the top 2 selling packages where status is "Order Finished"
                    $sql1 = "
                        SELECT p.*, SUM(o.quantity) AS total_sold 
                        FROM order_transaction_history o 
                        JOIN package p ON o.item = p.package_name 
                        WHERE o.status = 'Order Finished' 
                        GROUP BY p.id 
                        ORDER BY total_sold DESC 
                        LIMIT 2";
                        
                    $result1 = mysqli_query($conn, $sql1);

                    if ($result1 && mysqli_num_rows($result1) > 0) {
                        while ($row1 = mysqli_fetch_assoc($result1)) {
                            ?>
                            <div class="col-lg-3">
                                <div class="card m-2">
                                    <div class="position-relative overflow-hidden d-flex justify-content-center align-items-center">
                                        <img src="../assets/image/package_image/<?php echo $row1['package_image']; ?>" alt="Package Image" class="img-fluid w-100 h-100">
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 opacity-0 hover-overlay">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_package_modal<?php echo $row1['id']; ?>">Add to Cart</button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <?php
                                            $packageName = $row1['package_name'];
                                            $displayName = (strlen($packageName) > 25) ? substr($packageName, 0, 25) . '...' : $packageName;
                                        ?>
                                        <a class="nav-link" href="view_package.php?id=<?php echo $row1['id']; ?>">
                                            <span><b><?php echo $displayName; ?></b> &#8369; <?php echo number_format($row1['package_price'], 2); ?></span>
                                            <p class="text-muted small">Sold: <?php echo $row1['total_sold']; ?> units</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }

                    // Query to get the top 2 selling products where status is "Order Finished"
                    $sql2 = "
                        SELECT p.*, SUM(o.quantity) AS total_sold 
                        FROM order_transaction_history o 
                        JOIN products p ON o.item = p.product_name 
                        WHERE o.status = 'Order Finished' 
                        GROUP BY p.id 
                        ORDER BY total_sold DESC 
                        LIMIT 2";
                        
                    $result2 = mysqli_query($conn, $sql2);

                    if ($result2 && mysqli_num_rows($result2) > 0) {
                        while ($row2 = mysqli_fetch_assoc($result2)) {
                            ?>
                            <div class="col-lg-3">
                                <div class="card m-2">
                                    <div class="position-relative overflow-hidden d-flex justify-content-center align-items-center">
                                        <img src="../assets/image/product_image/<?php echo $row2['product_image']; ?>" alt="Product Image" class="img-fluid w-100 h-100">
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 opacity-0 hover-overlay">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_product_modal<?php echo $row2['id']; ?>">Add to Cart</button>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <?php
                                            $productName = $row2['product_name'];
                                            $displayName = (strlen($productName) > 25) ? substr($productName, 0, 25) . '...' : $productName;
                                        ?>
                                        <a class="nav-link" href="view_product.php?id=<?php echo $row2['id']; ?>">
                                            <span><b><?php echo $displayName; ?></b> &#8369; <?php echo number_format($row2['price'], 2); ?></span>
                                            <p class="text-muted small">Sold: <?php echo $row2['total_sold']; ?> units</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p class='text-muted'>No best-selling products found.</p>";
                    }
                ?>
            </div>
        </div>



        <?php include "web_content/computer_display.php"; ?>
        <?php include "web_content/cctv_display.php"; ?>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            const now = new Date();
            const offset = 8; // PHT is UTC+8
            const philippineTime = new Date(now.getTime() + offset * 60 * 60 * 1000);

            // Format the date to YYYY-MM-DD
            const today = philippineTime.toISOString().split('T')[0];

            // Set the min attribute of the date input to today's date
            document.getElementById('dateInput').setAttribute('min', today);
            
            document.addEventListener('DOMContentLoaded', function() {
                const isNew = <?php echo json_encode($is_new); ?>;
                if (isNew != 1) {
                    const modal = new bootstrap.Modal(document.getElementById('is_new_account'), {
                        backdrop: 'static',
                        keyboard: false
                    });
                    modal.show();
                }

                // Form validation for password match
                const form = document.getElementById('newAccountForm');
                const password = document.getElementById('password');
                const confirmPassword = document.getElementById('confirmPassword');

                form.addEventListener('submit', function(event) {
                    const passwordValue = password.value.trim();
                    const confirmPasswordValue = confirmPassword.value.trim();

                    if (passwordValue != confirmPasswordValue) {
                        event.preventDefault();
                        confirmPassword.classList.add('is-invalid');
                    } else {
                        confirmPassword.classList.remove('is-invalid');
                    }
                });

                // Remove invalid state on input
                confirmPassword.addEventListener('input', function() {
                    confirmPassword.classList.remove('is-invalid');
                });
            });
        </script>
    </body>
</html>