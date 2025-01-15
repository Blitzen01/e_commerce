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
            .log-in-container-fluid {
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 50vh;
            }
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <hr class="mx-5">

        <div class="log-in-container-fluid">
            <div class="w-25"
                style="max-width: 800px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px; overflow: hidden;">

                <div id="login_form_layout" class="p-3">
                    <form action="sign_up.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Full Name"
                                autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="user_email" id="user_email" placeholder="Email"
                                autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="number" class="form-control" name="contact_number" id="contact_number" placeholder="Contact Number"
                                autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="user_password" id="user_password"
                                placeholder="Password" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="user_confirm_password" id="user_confirm_password"
                                placeholder="Confirm Password" autocomplete="off">
                        </div>
                        <div class="mb-1">
                            <button class="btn btn-danger w-100" type="submit">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>
    </body>
</html>