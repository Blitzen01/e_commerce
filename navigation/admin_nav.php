<?php
  $email = $_SESSION['admin_email'];

  $sql = "SELECT * FROM admin_account WHERE email = '$email'";
  $result = mysqli_query($conn, $sql);

  if($result) {
    while($row = mysqli_fetch_assoc($result)) {
      ?>
      <div id="sidebar" class="d-flex flex-column mt-3 mb-3">
        <img id="admin_logo" src="../../assets/image/hfa_logo.jpg" alt="">
        <span class="text-center border-bottom border-top border-danger">Admin: <b><?php echo $row['first_name']; ?></b></span>
        <ul class="nav nav-pills flex-column mb-auto">
            <li><a class="nav_bar nav-link" href="calendar.php"><i class="fa-regular fa-calendar"></i> Calendar</a></li>
            <li><a class="nav_bar nav-link" href="dashboard.php"><i class="fa-solid fa-gauge"></i> Dashboard</a></li>
            <li><a class="nav_bar nav-link" href="order.php"><i class="fa-solid fa-cart-shopping"></i> Orders</a></li>
            <li><a class="nav_bar nav-link" href="bookings.php"><i class="fa-solid fa-book"></i> Bookings</a></li>
            <li><a class="nav_bar nav-link" href="inventory.php"><i class="fa-solid fa-warehouse"></i> Inventory</a></li>
            <li><a class="nav_bar nav-link" href="cms.php"><i class="fa-solid fa-arrows-to-circle"></i> CMS</a></li>
            <li><a class="nav_bar nav-link" href="staff.php"><i class="fa-solid fa-clipboard-user"></i> Staff</a></li>
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