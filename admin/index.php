<?php
    include "../assets/cdn/cdn_links.php";
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/admin_style.css">

        <style>
            /* Container for the layout */
            .container-fluid {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background-color: #f0f0f0;
            }

            /* Logo section styling */
            .logo-section {
                background-color: #ff0000;
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 2rem;
            }

            .logo-section img {
                width: 150px;
                height: auto;
            }

            /* Adjust for mobile view */
            @media (max-width: 768px) {
                .logo-section {
                    order: -1;
                    text-align: center;
                }
            }
        </style>
    </head>

    <body>
        <div class="container-fluid">
            <div class="row w-100" style="max-width: 800px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px; overflow: hidden;">

                <!-- Login Form Section (Left side for desktop, bottom for mobile) -->
                <div id="login_form_layout" class="col-12 col-md-6 p-4">
                    <form action="web_content/calendar.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="admin_username" id="admin_username" placeholder="Email or Username" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="admin_password" id="admin_password" placeholder="Password" autocomplete="off">
                            <a href="#" class="nav-link text-primary p-0 mt-2">Forgot password?</a>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-danger w-100" type="submit">Log In</button>
                        </div>
                    </form>
                </div>

                <!-- Logo Section (right side for desktop, top for mobile) -->
                <div class="col-12 col-md-6 d-flex logo-section">
                    <img src="../assets/image/hfa_logo.png" alt="Logo">
                </div>

            </div>
        </div>
    </body>
</html>
