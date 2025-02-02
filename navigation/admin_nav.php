<?php
  $email = $_SESSION['admin_email'];

  $sql = "SELECT * FROM admin_account WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);

  if($result) {
    while($row = mysqli_fetch_assoc($result)) {
      ?>
      <div id="sidebar" class="d-flex flex-column mt-3 mb-3">
        <img id="admin_logo" src="../../assets/image/hfa_logo.png" alt="">
        <span class="text-center border-bottom border-top border-pink">Admin: <b><?php echo $row['first_name']; ?></b></span>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a class="nav_bar nav-link" href="calendar.php"><i class="fa-regular fa-calendar"></i> Calendar</a></li>
            <li><a class="nav_bar nav-link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li>
              <a class="nav_bar nav-link text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#order_nav" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-cart-shopping"></i> Orders
              </a>
              <div class="collapse ms-3" id="order_nav">
                <a class="nav_bar nav-link bg-light" href="order.php#table_order_booking" style="cursor: pointer;"><i class="fa-solid fa-cart-shopping"></i> Order Place</a>
                <a class="nav_bar nav-link bg-light" href="order.php#table_order_booked" style="cursor: pointer;"><i class="fa-solid fa-cart-shopping"></i> Order Accepted</a>
              </div>
            </li>
            <li>
              <a class="nav_bar nav-link text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#bookings_nav" aria-expanded="false" aria-controls="collapseExample">
                <i class="fa-solid fa-book"></i> Bookings
              </a>
              <div class="collapse ms-3" id="bookings_nav">
                <a class="nav_bar nav-link bg-light" href="bookings.php#table_booking" style="cursor: pointer;"><i class="fa-solid fa-cart-shopping"></i> Booking Place</a>
                <a class="nav_bar nav-link bg-light" href="bookings.php#table_booked" style="cursor: pointer;"><i class="fa-solid fa-book"></i> Booking Accepted</a>
              </div>
            </li>
            <li>
                <a class="nav_bar nav-link text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#transaction_history_nav" aria-expanded="false" aria-controls="collapseExample">
                  <i class="fa-solid fa-clipboard"></i> Transaction History
                </a>
              <div class="collapse ms-3" id="transaction_history_nav">
                <a class="nav_bar nav-link bg-light" href="transaction_history.php#order" style="cursor: pointer;"><i class="fa-solid fa-cart-shopping"></i> Orders</a>
                <a class="nav_bar nav-link bg-light" href="transaction_history.php#booking" style="cursor: pointer;"><i class="fa-solid fa-book"></i> Bookings</a>
              </div>
            </li>
            <li>
                <a class="nav_bar nav-link text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#inventory_nav" aria-expanded="false" aria-controls="collapseExample">
                  <i class="fa-solid fa-warehouse"></i> Inventory</a>
                </a>
              <div class="collapse ms-3" id="inventory_nav">
                <a class="nav_bar nav-link bg-light" href="inventory.php#package_section" style="cursor: pointer;">Package List</a>
                <a class="nav_bar nav-link bg-light" href="inventory.php#product_section" style="cursor: pointer;">Product List</a>
              </div>
            </li>
            <li><a class="nav_bar nav-link" href="cms.php"><i class="fa-solid fa-arrows-to-circle"></i> CMS</a></li>
            <?php
              if($row['role'] == "Admin" || $row['role'] == "Owner") {
                ?>
                <li><a class="nav_bar nav-link" href="staff.php"><i class="fa-solid fa-clipboard-user"></i> Staff</a></li>
                <?php
              }
            ?>
            <li><a class="nav_bar nav-link" data-bs-toggle="modal" data-bs-target="#admin_logout" style="cursor: pointer;"><i class="fa-solid fa-arrow-right-from-bracket"></i> Log out</a></li>
        </ul>
      </div>

      <!-- Modal -->
      <div class="modal fade" id="admin_logout" tabindex="-1" aria-labelledby="admin_logout_label" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="admin_logout_label">Log Out</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <h5>Are you sure you want to log out ?</h5>
            </div>
            <div class="modal-footer">
              <a class="btn btn-primary" href="logout.php">Log out</a>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      <?php
    }
  }
?>