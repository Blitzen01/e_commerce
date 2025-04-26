<style>
#continuousCarousel .carousel-inner {
  transition: transform 2s linear;
}
</style>


<div id="carousel_display" class="carousel-container mb-3" style="<?php echo $carouselStyle; ?>">
    <div id="continuousCarousel" class="carousel slide shadow border overflow-hidden" data-bs-ride="carousel" data-bs-interval="2000">
        <div class="carousel-inner">
            <?php
            $sql = "SELECT * FROM carousel";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $isActive = true;
                while ($row = mysqli_fetch_assoc($result)) {
                    ?>
                    <div class="carousel-item <?php if ($isActive) echo 'active'; ?>">
                        <img src="../assets/image/carousel/<?php echo $row['img_name']; ?>" class="d-block w-100" alt="">
                    </div>
                    <?php
                    $isActive = false;
                }
            }
            ?>
        </div>
    </div>
</div>
