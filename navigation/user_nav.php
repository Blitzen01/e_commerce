<nav class="navbar navbar-expand-lg shadow mb-2 fixed-top bg-pink">
    <div class="container-fluid">
        <div class="col">
            <div class="row">
                <div class="col-1 m-1 p-1">
                    <a class="navbar-brand" href="index.php"><img id="user-logo" src="../assets/image/hfaLogo.jpg" alt="" srcset="" id="hfa_logo"></a>
                </div>
                <div class="col-5 my-auto me-auto search-container">
                    <form method="GET" action="index.php" class="d-flex">
                        <input class="form-control search_bar me-2" type="search" name="search" placeholder="Search for Products, Brands, Parts" aria-label="Search" autocomplete="off">
                        <button class="nav-link" type="submit"><i class="fa-solid fa-magnifying-glass search-icon"></i></button>
                    </form>
                </div>
                <div class="col my-auto">
                    <div class="row">
                        <div class="col-1 ms-auto">
                            <?php
                                if (isset($_SESSION['email'])) {
                                    $email = $_SESSION['email'];

                                    // Corrected SQL query
                                    $cart_items = "SELECT COUNT(*) AS cart_count FROM product_cart WHERE email = '$email'";
                                    $cart_result = mysqli_query($conn, $cart_items);

                                    // Check if the query executed successfully
                                    if ($cart_result) {
                                        $cart_result_row = mysqli_fetch_assoc($cart_result);
                                        $total_cart_result = $cart_result_row['cart_count'] ?? 0;
                                    } else {
                                        $total_cart_result = 0; // Fallback if query fails
                                    }
                                    ?>
                                    <a class="nav-link text-light position-relative" href="cart.php">
                                        <i class="fa-solid fa-cart-shopping text-dark"></i>
                                        <?php if ($total_cart_result > 0): ?>
                                            <span class="position-absolute top-50 end-0 translate-middle badge rounded-pill bg-danger" style="font-size: .5rem;">
                                                <?php echo htmlspecialchars($total_cart_result); ?>
                                                <span class="visually-hidden">items in cart</span>
                                            </span>
                                        <?php endif; ?>
                                    </a>
                                    <?php
                                } else {
                                    ?>
                                    <a class="nav-link text-light" href="sign_in.php">
                                        <i class="fa-solid fa-cart-shopping text-dark"></i>
                                    </a>
                                    <?php
                                }
                            ?>
                        </div>
                        <div class="col-1 me-2"> 
                            <?php
                                if (isset($_SESSION['email'])) {
                                    ?>
                                        <a class="nav-link text-light" href="user_profile.php"><i class="fa-solid fa-user text-dark"></i></a>
                                    <?php
                                } else {
                                    ?>
                                        <a class="nav-link text-light" href="sign_in.php"><i class="fa-solid fa-user text-dark"></i></a>
                                    <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div id="user_navbar" class="row">
                <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" href="index.php#computer">Computers</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" href="index.php#cctv">CCTV's</a>
                        </li>
                        <?php
                        if (isset($_SESSION['email'])) {
                            $email = $_SESSION['email'];
                            
                            ?>
                                <li class="nav-item mx-auto">
                                    <button class="nav-link text-light" data-bs-toggle="modal" data-bs-target="#create_scheduled_booking">Booking</button>
                                </li>
                                <li class="nav-item mx-auto">
                                    <button class="nav-link text-light" data-bs-toggle="modal" data-bs-target="#log_out_modal">Log Out</button>
                                </li>
                            <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<br><br><br><br><br>
