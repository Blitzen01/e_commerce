<?php
    session_start();

    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";

    // Get search query from URL parameters if present
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="carousel-container mb-3">
            <div id="continuousCarousel" class="carousel slide shadow border" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner">
                    <?php
                    $sql = "SELECT * FROM carousel";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        $isActive = true; // To set the "active" class only on the first item
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="carousel-item <?php if ($isActive) echo 'active'; ?>">
                                <img src="../assets/image/carousel/<?php echo $row['img_name']; ?>" class="d-block w-100" alt="">
                            </div>
                            <?php
                            $isActive = false; // Ensure only the first item has the "active" class
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="container" id="computer">
            <div class="row">
                <?php
                    // Filter packages based on search query
                    $sql1 = "SELECT * FROM package WHERE package_name LIKE '%$searchQuery%'";
                    $result1 = mysqli_query($conn, $sql1);

                    if ($result1) {
                        while ($row1 = mysqli_fetch_assoc($result1)) {
                            ?>
                            <div class="col-lg-3">
                                <div class="card m-2">
                                    <div class="position-relative overflow-hidden d-flex justify-content-center align-items center">
                                        <img src="../assets/image/package_image/<?php echo $row1['package_image']; ?>" alt="Package Image" class="img-fluid w-100 h-100">
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 opacity-0 hover-overlay">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_package_modal<?php echo $row1['id']; ?>">Add to Cart</button>
                                        </div>
                                    </div>

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

        <!-- product display -->
        <div class="container" id="cctv">
            <div class="row">
                <?php
                    // Filter products based on search query
                    $sql = "SELECT * FROM products WHERE product_name LIKE '%$searchQuery%'";
                    $result = mysqli_query($conn, $sql);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="col-lg-3">
                                <div class="card m-2">
                                    <!-- Image Section -->
                                    <div class="position-relative overflow-hidden d-flex justify-content-center align-items-center" style="height: 200px;">
                                        <img src="../assets/image/product_image/<?php echo $row['product_image']; ?>" alt="Product Image" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 opacity-0 hover-overlay">
                                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_to_cart<?php echo $row['id']; ?>">Add to Cart</button>
                                        </div>
                                    </div>

                                    <!-- Product Details -->
                                    <div class="card-body">
                                        <?php
                                            $productName = $row['product_name'];
                                            if (strlen($productName) > 35) {
                                                $displayName = substr($productName, 0, 35) . '...';
                                            } else {
                                                $displayName = $productName;
                                            }
                                        ?>
                                        <a class="nav-link" href="view_product.php?id=<?php echo $row['id']; ?>">
                                            <span><b><?php echo $displayName; ?></b> &#8369; <?php echo number_format($row['price'], 2); ?></span>
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
        </script>
    </body>
</html>