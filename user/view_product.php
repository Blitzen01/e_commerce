<?php

    session_start();

    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";

    // Get the product ID from the query parameter
    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        
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
        <title>
            <?php echo $product['product_name']; ?>
        </title>
        
        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>
    
    <body>
        <?php include "../navigation/user_nav.php"; ?>
        <?php include "chat.php"; ?>

        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-sm-10">
                    <div class="text-center p-2">
                        <!-- Product Image -->
                        <img src="../assets/image/product_image/<?php echo $product['product_image']; ?>" alt="Product Image" class="image-fluid border shadow fixed-height-image">
                    </div>
                </div>
                <div class="col-lg-6 col-sm-10">
                    <!-- Product Details -->
                    <h2><?php echo $product['product_name']; ?></h2>
                    <p class="text-muted">Price: &#8369; <?php echo number_format($product['price'], 2); ?></p>
                    <br><br>
                    <div class="ms-3">
                        <?php
                            if (!empty($_SESSION['email'])) {
                                ?>
                                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#add_to_cart<?php echo $id; ?>">Add to Cart</button>
                                <?php
                            } else {
                                ?>
                                    <a class="btn btn-secondary" href="sign_in.php">Add to Cart</a>
                                <?php
                            }
                        ?>
                        <button 
                            class="btn btn-pink ms-2" 
                            onclick="checkLoginStatusAndShowModal(<?php echo isset($_SESSION['email']) ? 'true' : 'false'; ?>)"                        >
                            Buy Now
                        </button>
                        <br>
                        <?php
                            // Fetch and calculate star ratings
                            $reviewPackageName = $product['product_name'];
                            $ratingSql = "SELECT COUNT(*) AS total_reviews, AVG(rating) AS avg_rating FROM order_review WHERE item_name = ?";
                            $stmt = $conn->prepare($ratingSql);
                            $stmt->bind_param("s", $reviewPackageName);
                            $stmt->execute();
                            $ratingResult = $stmt->get_result();

                            $averageRating = 0;
                            $totalReviews = 0;

                            if ($ratingRow = $ratingResult->fetch_assoc()) {
                                $averageRating = round($ratingRow['avg_rating'], 1); // Round to 1 decimal place
                                $totalReviews = $ratingRow['total_reviews'];
                            }
                        ?>
                        <h4 id="star_review_ratings" class=" mt-3">
                            <?php if ($totalReviews > 0): ?>
                                Star Rating: <span class="text-warning"><i class="fa-solid fa-star"></i> </span><?php echo $averageRating; ?>
                            <?php else: ?>
                                Star Rating: <span class="text-warning"><i class="fa-solid fa-star"></i> </span>N/A
                            <?php endif; ?>
                        </h4>
                    </div>
                </div>
            </div>

            <!-- product reviews -->
            <div class="container mt-4">
                <h4 class="mb-3">Customer Reviews</h4>
                <div class="row">
                    <?php
                    $reviewPackageName = $product['product_name'];
                    $reviewSql = "SELECT * FROM order_review WHERE item_name = '$reviewPackageName' ORDER BY review_date DESC";
                    $reviewResult = mysqli_query($conn, $reviewSql);

                    if ($reviewResult && mysqli_num_rows($reviewResult) > 0) {
                        while ($reviewRow = mysqli_fetch_assoc($reviewResult)) {
                            ?>
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    <!-- Review Picture -->
                                    <img src="../assets/image/order_review_image/<?php echo $reviewRow['picture']; ?>" class="card-img-top" alt="Review Image" style="max-height: 200px; object-fit: cover;">
                                    
                                    <div class="card-body">
                                        <!-- Rating Stars -->
                                        <div class="d-flex mb-2">
                                            <?php
                                            for ($i = 1; $i <= 5; $i++) {
                                                if ($i <= $reviewRow['rating']) {
                                                    echo '<i class="bi bi-star-fill text-warning"></i>'; // Filled star
                                                } else {
                                                    echo '<i class="bi bi-star text-warning"></i>'; // Empty star
                                                }
                                            }
                                            ?>
                                        </div>

                                        <!-- Review Text -->
                                        <p class="card-text">
                                            <?php echo htmlspecialchars($reviewRow['remarks']); ?>
                                        </p>

                                        <!-- Review Date -->
                                        <small class="text-muted">Reviewed on: <?php echo date("F j, Y, g:i a", strtotime($reviewRow['review_date'])); ?></small>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo "<p class='text-muted'>No reviews yet for this item.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- other products -->
            <div class="row">
                <span class="text-secondary">Other Products</span>
                <?php
                    $sql1 = "SELECT * FROM products WHERE id != $id";
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
                                            src="../assets/image/product_image/<?php echo $row1['product_image']; ?>" 
                                            alt="Product Image" 
                                            class="img-fluid w-100 h-100" 
                                            style="object-fit: cover;">
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 opacity-0 hover-overlay">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_to_cart<?php echo $id; ?>">Add to Cart</button>
                                        </div>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="card-body">
                                        <?php
                                            $productName = $row1['product_name'];
                                            if (strlen($productName) > 35) {
                                                $displayName = substr($productName, 0, 35) . '...';
                                            } else {
                                                $displayName = $productName;
                                            }
                                        ?>
                                        <a class="nav-link" href="view_product.php?id=<?php echo $row1['id']; ?>">
                                            <span><b><?php echo $displayName; ?></b> &#8369; <?php echo number_format($row1['price'], 2); ?></span>
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
            const now = new Date();
            const offset = 8; // PHT is UTC+8
            const philippineTime = new Date(now.getTime() + offset * 60 * 60 * 1000);

            // Format the date to YYYY-MM-DD
            const today = philippineTime.toISOString().split('T')[0];

            // Set the min attribute of the date input to today's date
            document.getElementById('dateInput').setAttribute('min', today);

            // Check login status and show the modal
            function checkLoginStatusAndShowModal(isLoggedIn) {
                if (!isLoggedIn) {
                    // Redirect to login page if not logged in
                    alert("You must be logged in to proceed.");
                    window.location.href = "sign_in.php";
                } else {
                    // Show the Bootstrap modal
                    const modalElement = document.getElementById("product_buy_now");
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
<div class="modal fade" id="product_buy_now" tabindex="-1" aria-labelledby="product_buy_now_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="product_buy_now_label"><?php echo $product['product_name']; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <img src="../assets/image/product_image/<?php echo $product['product_image']; ?>" alt="Product Image" class="img-fluid mb-3 p-2 border shadow" style="max-height: 200px;">
                </div>
                <p class="text-muted text-center">Price: &#8369; <?php echo number_format($product['price'], 2); ?></p>
                <div class="d-flex justify-content-center align-items-center">
                    <button class="btn btn-outline-secondary me-2" onclick="adjustQuantity(-1, <?php echo $product['stocks']; ?>)">-</button>
                    <input type="text" id="quantityInput" class="form-control text-center" value="1" style="width: 60px;" readonly>
                    <button class="btn btn-outline-secondary ms-2" onclick="adjustQuantity(1, <?php echo $product['stocks']; ?>)">+</button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" id="confirmPurchaseLink" href="confirm_product_purchase.php?id=<?php echo $product['id']; ?>&quantity=1">Confirm Purchase</a>
            </div>
        </div>
    </div>
</div>
<!-- Modal for Buy Now -->