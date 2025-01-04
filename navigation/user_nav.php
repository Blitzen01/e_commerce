<nav class="navbar navbar-expand-lg shadow mb-2 fixed-top bg-light">
    <div class="container-fluid">
        <div class="col">
            <div class="row">
                <div class="col-1 m-1 p-1">
                    <a class="navbar-brand" href="index.php"><img src="../assets/image/hfa_logo.png" alt="" srcset="" id="hfa_logo"></a>
                </div>
                <div class="col-5 my-auto me-auto search-container">
                    <input class="form-control search_bar me-2" type="search" placeholder="Search for Products, Brands, Parts" aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                </div>
                <div class="col-1 my-auto">
                    <?php
                        if (isset($_SESSION['email'])) {
                            ?>
                                <a class="nav-link text-light" href="cart.php"><i class="fa-solid fa-cart-shopping text-dark"></i></a> 
                            <?php
                        } else {
                            ?>
                                <a class="nav-link text-light" href="sign_in.php"><i class="fa-solid fa-cart-shopping text-dark"></i></a>
                            <?php
                        }
                    ?>
                </div>
                <div class="col-1 my-auto">
                    <?php
                        if (isset($_SESSION['email'])) {
                            ?>
                                <a class="nav-link" href="chats.php"><i class="fa-solid fa-comments"></i></a> 
                            <?php
                        } else {
                            ?>
                                <a class="nav-link" href="sign_in.php"><i class="fa-solid fa-comments"></i></a>
                            <?php
                        }
                    ?>
                </div>
                <div class="col-1 my-auto"> 
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
                            <a class="nav-link text-light" href="#computer">Computers</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" href="#laptop">Laptop</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" href="#cctv">CCTV's</a>
                        </li>
                        <?php
                        if (isset($_SESSION['email'])) {
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