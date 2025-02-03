<div id="carousel_display" class="carousel-container mb-3" style="<?php echo $carouselStyle; ?>">
    <div id="continuousCarousel" class="carousel slide shadow border" data-bs-ride="carousel" data-bs-interval="3000">
        <div class="carousel-inner">
            <?php
            $sql = "SELECT * FROM carousel";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $isActive = true; // To set the "active" class only on the first item
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="carousel-item <?php if ($isActive) echo 'active'; ?>">
                        <img src="../assets/image/carousel/<?php echo $row['img_name']; ?>" class="d-block w-100" alt="">
                    </div>
                    <?php
                    $isActive = false; // Ensure only the first item has the "active" class
                }
            }
            ?>
        </div>
    </div>
</div>