<nav class="navbar navbar-expand-lg shadow-sm mb-2 fixed-top bg-pink">
  <div class="container-fluid">
    <div class="row w-100 align-items-center">
      
      <!-- Logo -->
      <div class="col-auto p-1">
        <a class="navbar-brand d-flex align-items-center" href="index.php">
          <img src="../assets/image/hfaLogo.jpg" alt="HFA Logo" id="hfa_logo" style="height: 45px;" class="rounded">
        </a>
      </div>

      <!-- Search Bar -->
      <div class="col-5">
        <form method="GET" action="index.php" class="d-flex">
          <input class="form-control form-control-sm me-2 search_bar" type="search" name="search" placeholder="Search for Products, Brands, Parts" aria-label="Search" autocomplete="off">
          <button class="btn btn-light btn-sm" type="submit">
            <i class="fa-solid fa-magnifying-glass"></i>
          </button>
        </form>
      </div>

      <!-- Icons (Cart & User) -->
      <div class="col d-flex justify-content-end align-items-center">
        <div class="d-flex align-items-center me-3">
          <?php
            if (isset($_SESSION['email'])) {
              $email = $_SESSION['email'];
              $cart_items = "SELECT COUNT(*) AS cart_count FROM product_cart WHERE email = '$email'";
              $cart_result = mysqli_query($conn, $cart_items);
              $total_cart_result = $cart_result ? mysqli_fetch_assoc($cart_result)['cart_count'] ?? 0 : 0;
          ?>
            <a class="nav-link position-relative" href="cart.php">
              <i class="fa-solid fa-cart-shopping text-dark"></i>
              <?php if ($total_cart_result > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: .6rem;">
                  <?php echo htmlspecialchars($total_cart_result); ?>
                  <span class="visually-hidden">items in cart</span>
                </span>
              <?php endif; ?>
            </a>
          <?php } else { ?>
            <a class="nav-link" href="sign_in.php">
              <i class="fa-solid fa-cart-shopping text-dark"></i>
            </a>
          <?php } ?>
        </div>

        <div class="d-flex align-items-center">
          <?php if (isset($_SESSION['email'])) { ?>
            <a class="nav-link" href="user_profile.php"><i class="fa-solid fa-user text-dark"></i></a>
          <?php } else { ?>
            <a class="nav-link" href="sign_in.php"><i class="fa-solid fa-user text-dark"></i></a>
          <?php } ?>
        </div>
      </div>

      <!-- Toggler (Mobile) -->
      <div class="col-auto">
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#user_navbar" aria-controls="user_navbar" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
      </div>

      <!-- Navbar Links -->
      <div class="collapse navbar-collapse mt-2" id="user_navbar">
        <ul class="navbar-nav mx-auto text-center">
          <li class="nav-item mx-2">
            <a class="nav-link text-light" href="index.php">Home</a>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link text-light" href="computers.php">Computers</a>
          </li>
          <li class="nav-item mx-2">
            <?php if (isset($_SESSION['email'])) { ?>
              <a class="nav-link text-light" href="customize.php">Customize</a>
            <?php } else { ?>
              <a class="nav-link text-light" href="sign_in.php">Customize</a>
            <?php } ?>
          </li>
          <li class="nav-item mx-2">
            <a class="nav-link text-light" href="cctv.php">CCTV's</a>
          </li>
          <?php if (isset($_SESSION['email'])) { ?>
            <li class="nav-item mx-2">
              <button class="nav-link text-light bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#create_scheduled_booking">Booking</button>
            </li>
            <li class="nav-item mx-2">
              <button class="nav-link text-light bg-transparent border-0" data-bs-toggle="modal" data-bs-target="#log_out_modal">Log Out</button>
            </li>
          <?php } ?>
        </ul>
      </div>
    </div>
  </div>
</nav>

<!-- Margin Spacer -->
<div style="margin-top: 120px;"></div>
