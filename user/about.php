<?php
    session_start();
    
    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";
    include "../render/modals.php";

    // Get search query from URL parameters if present
    $searchQuery = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">

        <style>
            .modal-dialog {
                max-height: calc(100% - 1rem); /* Ensures the modal does not overflow the viewport */
                overflow-y: auto; /* Enables vertical scrolling within the modal */
            }

            .modal-body {
                max-height: 70vh; /* Adjust as needed */
                overflow-y: auto; /* Ensures the scroll is inside the modal body */
            }

            /* Mobile Responsiveness */
            @media (max-width: 768px) {
                .card-body {
                    font-size: 14px;  /* Adjust text size for small screens */
                }
                .col-lg-6 {
                    margin-bottom: 20px;  /* Adjust layout for mobile */
                }
            }
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>
        <?php include "chat.php"; ?>

        <div class="container">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6">
                    <!-- picture of the stablishment -->
                    <img class="card shadow" src="../assets/image/owner.jpg" alt="Owner of HFA Computer Parts and Repair Services" loading="lazy" style="width: 100%;">
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
                    <h4><b>HFA Vision:</b> HFA Computer Parts and Repair Services envisions to become a world-class IT Solutions company.</h4>
                    <br>
                    <h4>
                        <b>Values:</b> Integrity, Respect for people, High Performance, Quality, and Excellence are the core values represented by HFA 
                        Computer Parts and Repair Services to develop our business.
                    </h4>
                </div>
                <div class="col-lg-6">
                    <img src="../assets/image/establishment.jpg" alt="HFA Computer Parts and Repair Services Establishment" loading="lazy" style="width: 100%;">
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-7">
                    <!-- Embed Google Maps -->
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3177.806073408604!2d120.8502137!3d14.3917662!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x33962d8c60f24613%3A0x7ad61bb88a8bdfe8!2sHFA+Computer+Parts+and+Repair+Services!5e0!3m2!1sen!2sph!4v1684101498967!5m2!1sen!2sph" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
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

        <script>
            const now = new Date();
            const offset = 8; // PHT is UTC+8
            const philippineTime = new Date(now.getTime() + offset * 60 * 60 * 1000);

            // Format the date to YYYY-MM-DD
            const today = philippineTime.toISOString().split('T')[0];

            // Set the min attribute of the date input to today's date
            document.getElementById('dateInput').setAttribute('min', today);
        </script>
    </body>
</html>
