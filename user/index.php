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


        <div class="container-fluid text-center bg-dark">
            <div class="row text-light justify-content-center">
                <div class="col-lg-6 col-sm-10 m-3 mx-auto text-center">
                    <h2>About Us</h2>
                    <span style="text-align: justify;">Founded in January 2019 by Rhaian Fornosdoro, 
                        our business has grown with a commitment to providing quality services and customer satisfaction. 
                        Located on the Tanza-Trece Martires Road, our office is conveniently situated on the 2nd floor of 
                        the DKP Commercial Building in Daang Amaya 1, Tanza, Cavite.
                        <br>
                        With a focus on excellence, we aim to serve our community and beyond with dedication and professionalism. 
                        Whether you're visiting us for the first time or returning as a valued client, we look forward to helping 
                        you meet your needs and exceed your expectations.
                    </span>
                    <br>
                    <a href="" class="btn btn-info p-2 mt-3">See More</a>
                </div>
                <div class="col-lg-6 col-sm-10 mx-auto text-center">
                    <h2>Contact Us</h2>
                    <div class="row mb-3">
                        <a class="nav-link text-primary" href="https://www.facebook.com/HFAComputers"><i class="fa-brands fa-facebook"></i> HFA Computers and Repair Service</a>
                    </div>
                    <div class="row mb-3">
                        <a class="nav-link text-warning" href="https://www.instagram.com/hfacomputerparts/"><i class="fa-brands fa-instagram"></i> HFA Computers and Repair Service</a>
                    </div>
                    <div class="row mb-3">
                        <a class="nav-link" href="viber://chat?number=+09179784098" style="color: #7360f2;"><i class="fa-brands fa-viber"></i> 09179784098</a>
                    </div>
                    <div class="row mb-3">
                        <a class="nav-link" href="javascript:void(0);" onclick="copyToClipboard('09179784098')"><i class="fa-solid fa-phone text-light"></i> 09179784098</a>
                    </div>
                </div>
            </div>
            <div class="row border-top border-secondary text-secondary text-center mt-3">
                <span>&copy; 2024 HFA Computer Parts and Repair Services. All rights reserved.</span>
            </div>
        </div>

        <script>
            function copyToClipboard(text) {
                navigator.clipboard.writeText(text).then(function() {
                    alert('Phone number copied to clipboard');
                }).catch(function(error) {
                    console.error('Error copying text: ', error);
                });
            }
        </script>
    </body>
</html>