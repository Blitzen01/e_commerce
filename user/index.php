<?php
    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">

        <style>
            
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="m-3 shadow border">
            <div id="continuousCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="1000">
                <div class="carousel-inner">
                    <?php
                        $sql = "SELECT * FROM carousel";
                        $result = mysqli_query($conn, $sql);

                        if($result) {
                            $isActive = true; // Variable to track the first item
                            while($row = mysqli_fetch_assoc($result)) {
                                ?>
                                <div class="carousel-item <?php if ($isActive) { echo 'active'; $isActive = false; } ?>">
                                    <img src="../assets/image/carousel/<?php echo $row['img_name']; ?>.jpg">
                                </div>
                                <?php
                            }
                        }
                    ?>
                </div>
            </div>
        </div>


        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>
        <script>
            

        </script>
    </body>
</html>