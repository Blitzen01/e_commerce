<div class="container" id="best_selling">
    <h3><b>Top Best-Selling Products</b></h3>

    <div class="row">
        <?php
            // Get the search query from the input field
            $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

            // Query to get the top 2 selling packages where status is "Order Finished" and matches search
            $sql1 = "
                SELECT p.*, SUM(o.quantity) AS total_sold 
                FROM order_transaction_history o 
                JOIN package p ON o.item = p.package_name 
                WHERE o.status = 'Order Finished' 
                AND p.package_name LIKE '%$searchQuery%'
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

            // Query to get the top 2 selling products where status is "Order Finished" and matches search
            $sql2 = "
                SELECT p.*, SUM(o.quantity) AS total_sold 
                FROM order_transaction_history o 
                JOIN products p ON o.item = p.product_name 
                WHERE o.status = 'Order Finished' 
                AND p.product_name LIKE '%$searchQuery%'
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