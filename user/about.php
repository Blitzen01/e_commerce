<?php
    session_start();
    
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

        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6">
                    <!-- picture of the stablishment -->
                    <img class="card shadow" src="../assets/image/owner.jpg" alt="" srcset="" style="width: 100%;">
                </div>
                <div class="col m-3">
                    <h4>Founded in <b>January 2019</b> by <b><u>Rhaian Fornosdoro</u></b>, our business has grown with a commitment to providing quality 
                        services and customer satisfaction.
                        <br><br>
                        With a focus on excellence, we aim to serve our community and beyond with dedication and professionalism. Whether 
                        you're visiting us for the first time or returning as a valued client, we look forward to helping you meet your needs 
                        and exceed your expectations.
                    </h4>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col m-3">
                    <h4>
                        <b>HFA MISSION:</b> The HFA Computer Parts and Repair Services exists to provide quality products and services that facilitates
                        the needs and satisfaction of every customers.
                    </h4>
                    <br>
                    <h4><b>HFA Vision:</b> HFA Computer Parts and Repair Services evisions to become a world class IT Solutions company.</h4>
                    <br>
                    <h4>
                        <b>Values:</b> Integrity, Respect for people, High Performance, Quality and Excellence are the core values represented of HFA 
                        Computer Parts and Repair Services to develop our business.
                    </h4>
                </div>
                <div class="col-lg-6">
                    <img src="../assets/image/establishment.jpg" alt="" srcset="" style="width: 100%;">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-7">
                    <a href="https://www.google.com/maps/place/HFA+Computer+Parts+and+Repair+Services/@14.3900982,120.8421885,15z/data=!4m6!3m5!1s0x33962d8c60f24613:0x7ad61bb88a8bdfe8!8m2!3d14.391761!4d120.8527886!16s%2Fg%2F11vhc05_m0?entry=ttu&g_ep=EgoyMDI0MTExMi4wIKXMDSoASAFQAw%3D%3D"
                        target="blank()">
                        <img class="border border-dark shadow" src="../assets/image/location.jpg" alt="" srcset="">
                    </a>
                </div>
                <div class="col m-3">
                    <h5>Located on the <b>Tanza-Trece Martires Road</b>, our office is conveniently situated 
                    on the <b>2nd floor of the DKP Commercial Building in Daang Amaya 1, Tanza, Cavite</b>.</h5>
                </div>
            </div>
        </div>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>
    </body>
</html>