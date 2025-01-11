<nav class="navbar navbar-expand-lg sticky-top" style="background: white;">
    <ul class="navbar-nav ms-auto me-3">
        <li class="nav-item dropdown">
            <?php
                // Query to count low-stock items
                $sql = "SELECT COUNT(*) AS low_stock_count FROM (
                            SELECT stocks FROM package WHERE stocks <= 10
                            UNION ALL
                            SELECT stocks FROM products WHERE stocks <= 10
                        ) AS low_stock_items";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                $low_stock_count = $row['low_stock_count'] ?? 0;

                $order_booking_count = "SELECT COUNT(*) AS order_count FROM order_booking";
                $order_booking_count_result = mysqli_query($conn, $order_booking_count);
                $order_booking_count_result_row = mysqli_fetch_assoc($order_booking_count_result);
                $total_booking_order_count = $order_booking_count_result_row['order_count'] ?? 0;

                $booking_count = "SELECT COUNT(*) AS booking_count FROM booked";
                $booking_count_result = mysqli_query($conn, $booking_count);
                $booking_count_result_row = mysqli_fetch_assoc($booking_count_result);
                $total_booking_count = $booking_count_result_row['booking_count'] ?? 0;
                $total_notif = $low_stock_count + $total_booking_order_count + $total_booking_count;

            ?>
            <a class="nav-link me-3 position-relative" href="#" id="stockDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <h5><i class="fa-solid fa-bell"></i></h5>
                <?php if ($total_notif > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $total_notif; ?>
                        <span class="visually-hidden">unread notifications</span>
                    </span>
                <?php endif; ?>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="stockDropdown">
                <?php
                    $sql = "SELECT 'package' AS type, id AS id, package_name AS name, stocks 
                    FROM package 
                    WHERE stocks <= 10
                    UNION
                    SELECT 'product' AS type, id AS id, product_name AS name, stocks 
                    FROM products 
                    WHERE stocks <= 10";            
                    $result = mysqli_query($conn, $sql);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            ?>
                                <li>
                                    <a class="dropdown-item" href="inventory.php#<?php echo urlencode($row['type'] . '_' . $row['id']); ?>">
                                        <?php echo strtoupper(htmlspecialchars($row['type'])); ?>: 
                                        <b><?php echo htmlspecialchars($row['name']); ?></b> 
                                        (Stocks: <?php echo (int)$row['stocks']; ?>)
                                    </a>
                                </li>
                            <?php
                        }
                    } else {
                        echo '<li><a class="dropdown-item" href="#">No low-stock items</a></li>';
                    }    
                    
                    $booking_notif = "SELECT * FROM booked";
                    $booking_notif_result = mysqli_query($conn, $booking_notif);

                    if ($booking_notif_result && mysqli_num_rows($booking_notif_result) > 0) {
                        while ($booking_notif_result_row = mysqli_fetch_assoc($booking_notif_result)) {
                            ?>
                            <li>
                                <a class="dropdown-item" href="bookings.php">
                                    <b><?php echo htmlspecialchars($booking_notif_result_row['name']); ?></b><br>
                                    Booking: <?php echo htmlspecialchars($booking_notif_result_row['type_of_booking']); ?>
                                </a>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li><a class="dropdown-item" href="#">No bookings available</a></li>
                        <?php
                    }

                    $order_booking_notif = "SELECT * FROM order_booking";
                    $order_booking_notif_result = mysqli_query($conn, $order_booking_notif);

                    if ($order_booking_notif_result && mysqli_num_rows($order_booking_notif_result) > 0) {
                        while ($order_booking_notif_result_row = mysqli_fetch_assoc($order_booking_notif_result)) {
                            ?>
                            <li>
                                <a class="dropdown-item" href="order.php">
                                    <b><?php echo htmlspecialchars($order_booking_notif_result_row['name']); ?></b><br>
                                    Order: <?php echo htmlspecialchars($order_booking_notif_result_row['item']); ?>
                                </a>
                            </li>
                            <?php
                        }
                    } else {
                        ?>
                        <li><a class="dropdown-item" href="#">No bookings available</a></li>
                        <?php
                    }
                ?>
            </ul>
        </li>
        <li class="nav-item">
            <a class="nav-link me-3" href="chats.php"><h5><i class="fa-solid fa-comment"></i></h5></a>
        </li>
        <li class="nav-item">
            <a class="nav-link me-3" href="account_settings.php"><h5><i class="fa-solid fa-user"></i></h5></a>
        </li>
    </ul>
</nav>
