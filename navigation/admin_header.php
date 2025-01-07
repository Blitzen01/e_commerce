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

            ?>
            <a class="nav-link me-3 position-relative" href="#" id="stockDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <h5><i class="fa-solid fa-bell"></i></h5>
                <?php if ($low_stock_count > 0): ?>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        <?php echo $low_stock_count; ?>
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
                            echo '<li><a class="dropdown-item" href="inventory.php#' . $row['type'] . '_' . $row['id'] . '">' . $row['type'] . ': ' . $row['name'] . ' (Stock: ' . $row['stocks'] . ')</a></li>';
                        }
                    } else {
                        echo '<li><a class="dropdown-item" href="#">No low-stock items</a></li>';
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
