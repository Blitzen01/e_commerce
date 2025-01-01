<?php
    session_start();

    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">

        <style>
            
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="m-3 shadow border">
            <div id="continuousCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1000">
                <div class="carousel-inner">
                    <?php
                        $sql = "SELECT * FROM carousel";
                        $result = mysqli_query($conn, $sql);

                        if($result) {
                            $isActive = true; // Variable to track the first item
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <div class="carousel-item <?php if ($isActive) { echo 'active'; $isActive = false; } ?>">
                                    <img src="../assets/image/carousel/<?php echo $row['img_name']; ?>.jpg">
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <?php
                    $sql = "SELECT * FROM products";
                    // $sql1 = "SELECT * FROM package";

                    $result = mysqli_query($conn, $sql);
                    // $result1 = mysqli_query($conn, $sql1);

                    if($result) {  //$result && $result1
                        while($row = mysqli_fetch_assoc($result)) {
                            ?>
                            <div class="col">
                                <div class="card m-2">
                                    <!-- Image Section -->
                                    <div class="position-relative overflow-hidden d-flex justify-content-center align-items-center" style="height: 200px;">
                                        <img 
                                            src="../assets/image/product_image/<?php echo $row['product_image']; ?>" 
                                            alt="Product Image" 
                                            class="img-fluid w-100 h-100" 
                                            style="object-fit: cover;">
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
    </body>
</html>