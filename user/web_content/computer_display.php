<style>
/* Scale the card when hovered */
.card:hover {
    transform: scale(1.02);
    transition: transform 0.3s ease;
}

/* Make overlay and button fade in */
.hover-overlay {
    opacity: 0;
    transition: opacity 0.3s ease;
}

/* When parent is hovered, show the overlay */
.position-relative:hover .hover-overlay {
    opacity: 1;
}

/* Optional: Smooth zoom effect for image */
.card img {
    transition: transform 0.5s ease;
}

.card:hover img {
    transform: scale(1.05);
}
</style>


<div class="container" id="computer">
    <span class="text-muted">Other products</span>
    <div class="row">
        <?php
            $sql1 = "SELECT * FROM package WHERE package_name LIKE '%$searchQuery%'";
            $result1 = mysqli_query($conn, $sql1);

            if ($result1) {
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    ?>
                    <div class="col-lg-3">
                        <div class="card m-2">
                            <div class="position-relative overflow-hidden d-flex justify-content-center align-items-center">
                                <img src="../assets/image/package_image/<?php echo $row1['package_image']; ?>" alt="Package Image" class="img-fluid w-100 h-100">
                                
                                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center bg-dark bg-opacity-50 hover-overlay">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add_package_modal<?php echo $row1['id']; ?>">Add to Cart</button>
                                </div>
                            </div>

                            <div class="card-body">
                                <?php
                                    $packageName = $row1['package_name'];
                                    $displayName = (strlen($packageName) > 25) ? substr($packageName, 0, 25) . '...' : $packageName;
                                ?>
                                <a class="nav-link" href="view_package.php?id=<?php echo $row1['id']; ?>">
                                    <span><b><?php echo $displayName; ?></b> &#8369; <?php echo number_format($row1['package_price'], 2); ?></span>
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
