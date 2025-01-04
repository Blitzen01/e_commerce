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

    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="carousel-container mb-3">
            <div id="continuousCarousel" class="carousel slide shadow border" data-bs-ride="carousel" data-bs-interval="1000">
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

        <div class="container" id="computer" style="margin-top: 100px;">
            <div class="row">qweqweqwe
            </div>
        </div>

        <div class="container" id="laptop" style="margin-top: 100px;">
            <div class="row">qeqweqw
            </div>
        </div>
        
        <!-- product display -->
        <div class="container" id="cctv" style="margin-top: 100px;">
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

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const navbarHeight = document.querySelector('.navbar').offsetHeight;
                const links = document.querySelectorAll('a.nav-link[href^="#"]');

                links.forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        const targetId = this.getAttribute('href').substring(1);
                        const targetElement = document.getElementById(targetId);

                        if (targetElement) {
                            const targetPosition = targetElement.offsetTop - navbarHeight;

                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth',
                            });
                        }
                    });
                });
            });
        </script>
    </body>
</html>