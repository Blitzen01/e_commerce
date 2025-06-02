<style>
/* Card hover scale */
.card:hover {
    transform: scale(1.02);
    transition: transform 0.3s ease;
}

/* Smooth image zoom */
.card img {
    transition: transform 0.5s ease;
}

.card:hover img {
    transform: scale(1.05);
}

/* Fade in the overlay */
.hover-overlay {
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* Show overlay on hover */
.position-relative:hover .hover-overlay {
    opacity: 1;
}
</style>


<!-- computer parts display -->
<div class="container" id="cctv">
    <div class="row">
        <?php
            // Filter products based on search query
            $sql = "SELECT * FROM computer_parts WHERE parts_name LIKE '%$searchQuery%'";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="col-lg-3">
                        <div class="card m-2">
                            <!-- Image Section -->
                            <div class="position-relative overflow-hidden d-flex justify-content-center align-items-center" style="height: 200px;">
                                <img src="../assets/image/computer_parts_image/<?php echo $row['image']; ?>" alt="Product Image" class="img-fluid w-100 h-100" style="object-fit: cover;">
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 opacity-0 hover-overlay">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_parts_modal<?php echo $row['id']; ?>">Add to Cart</button>
                                </div>
                            </div>

                            <!-- Product Details -->
                            <div class="card-body">
                                <?php
                                    $productName = $row['parts_name'];
                                    if (strlen($productName) > 25) {
                                        $displayName = substr($productName, 0, 25) . '...';
                                    } else {
                                        $displayName = $productName;
                                    }
                                ?>
                                <a class="nav-link" href="view_computer_parts.php?id=<?php echo $row['id']; ?>">
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
