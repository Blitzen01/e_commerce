<?php
    include "../assets/cdn/cdn_links.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">

        <style>
            .search-container {
                position: relative;
            }

            .search-container input {
                width: 100%;
                padding: 10px 40px 10px 15px; /* Adjust padding to make room for the icon */
                font-size: 16px;
            }

            .search-icon {
                position: absolute;
                right: 25px;
                top: 50%;
                transform: translateY(-50%);
                font-size: 16px;
                color: #ccc; /* Adjust the color if needed */
                cursor: pointer; /* Optional: to make it clickable */
            }
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <div class="container-fluid text-center bg-dark">
            <div class="row text-light">
                <div class="col">
                    <h2>About Us</h2>
                    <span>anyting related sakanila atleast 3 sentence.</span>
                </div>
                <div class="col">
                    <h2>Contact Us</h2>
                    <div class="row mb-3">
                        <a href=""><i class="fa-brands fa-facebook text-primary"></i></a>
                    </div>
                    <div class="row mb-3">
                        <a href=""><i class="fa-brands fa-instagram text-warning"></i></a>
                    </div>
                    <div class="row mb-3">
                        <a href=""><i class="fa-brands fa-twitter text-info"></i></a>
                    </div>
                    <div class="row mb-3">
                        <a href=""><i class="fa-solid fa-phone text-light"></i></a>
                    </div>
                </div>
            </div>
            <div class="row border-top border-secondary text-secondary">
                <span>&copy; 2024 HFA Computer Parts and Repair Services. All rights reserved.</span>
            </div>
        </div>
    </body>
</html>