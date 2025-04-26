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
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f7fb;
                color: #333;
                margin: 0;
                padding: 0;
            }

            .log-in-container-fluid {
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 20px;
                /* Optional: You can set a max-height or remove min-height for better control */
            }

            hr {
                margin-top: 20px;
                margin-bottom: 20px;
            }

            .registration-form-wrapper {
                background: #fff;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                width: 100%;
                max-width: 400px;
                padding: 30px;
                box-sizing: border-box;
                text-align: center;
            }

            .registration-form-wrapper h2 {
                font-size: 24px;
                margin-bottom: 20px;
                color: #2c3e50;
            }

            .signup {
                padding: 15px;
                border-radius: 5px;
                border: 1px solid #ccc;
                margin-bottom: 15px;
                width: 100%;
                font-size: 16px;
                box-sizing: border-box;
                transition: border-color 0.3s ease;
            }

            .signup:focus {
                border-color: #3498db;
                outline: none;
            }

            .btn-pink {
                background-color: #3498db;
                color: white;
                padding: 15px;
                border-radius: 5px;
                border: none;
                width: 100%;
                font-size: 16px;
                cursor: pointer;
                transition: background-color 0.3s ease;
            }

            .btn-pink:hover {
                background-color: #2980b9;
            }

            .container {
                margin-top: 20px;
                font-size: 14px;
            }

            .container a {
                color: #3498db;
                text-decoration: none;
            }

            .container a:hover {
                text-decoration: underline;
            }

            .separator {
                margin: 20px 0;
                text-align: center;
                color: #ccc;
            }

            @media (max-width: 480px) {
                .registration-form-wrapper {
                    width: 100%;
                    padding: 20px;
                }
            }
        </style>
    </head>

    <body>
        <?php include "../navigation/user_nav.php"; ?>

        <hr class="mx-5">

        <div class="log-in-container-fluid">
            <div class="registration-form-wrapper">
                <h2>Create an Account</h2>

                <form action="../assets/php_script/register.php" method="post">
                    <div class="mb-3">
                        <input type="text" class="form-control signup" name="full_name" id="full_name" placeholder="Full Name" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control signup" name="user_email" id="user_email" placeholder="Email" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control signup" name="user_password" id="user_password" placeholder="Password" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" class="form-control signup" name="user_confirm_password" id="user_confirm_password" placeholder="Confirm Password" autocomplete="off" required>
                    </div>
                    <div class="mb-1">
                        <button class="btn btn-pink w-100" type="submit">Register</button>
                    </div>
                </form>

                <div class="container mt-3">
                    <small>Already have an account? <a href="sign_in.php">Log In</a></small>
                </div>
            </div>
        </div>

        <hr class="mx-5 mt-3 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script defer src="../assets/script/user_script.js"></script>
    </body>
</html>
