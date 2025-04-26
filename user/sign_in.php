<?php
    session_start();
    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve email/username and password from the form
        $email = $_POST["user_email"]; // Corrected field name
        $password = $_POST["user_password"]; // Correct field name

        // Prepare SQL statement to select user with the provided email
        $sql = "SELECT * FROM user_account WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if a row was returned
        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            // Verify the password with password_verify()
            if (password_verify($password, $row['password'])) {
                // Start the session and redirect on successful login
                $_SESSION['email'] = $email; // Store the email in session
                echo "<script>
                            window.location.href = 'index.php';
                        </script>";
            } else {
                // Invalid password
                echo "<script>
                        alert('Invalid password. Please try again.');
                    </script>";
            }
        } else {
            // Invalid email
            echo "<script>
                    alert('Invalid email. Please try again.');
                </script>";
        }
    }

    if (isset($_SESSION['email'])) {
        $email = $_SESSION['email']; // User's email stored in the session

        // Check if the user is logging in for the first time
        $sql = "SELECT is_new FROM user_account WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $isFirstLogin = $user['is_new'] == 0; // Check if `is_new` is 0 (first-time login)
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">
        <script src="https://cdn.jsdelivr.net/npm/jwt-decode/build/jwt-decode.min.js"></script>

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
            }

            hr {
                margin-top: 20px;  /* Reduced top margin for the hr */
                margin-bottom: 20px;  /* Reduced bottom margin for the hr */
            }

            .login-form-wrapper {
                background: #fff;
                box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
                border-radius: 8px;
                width: 100%;
                max-width: 400px;
                padding: 30px;
                box-sizing: border-box;
                text-align: center;
                margin-top: 10px; /* Adjusted margin to reduce space */
            }

            .login-form-wrapper h2 {
                font-size: 24px;
                margin-bottom: 20px;
                color: #2c3e50;
            }

            .login_design {
                padding: 15px;
                border-radius: 5px;
                border: 1px solid #ccc;
                margin-bottom: 15px;
                width: 100%;
                font-size: 16px;
                box-sizing: border-box;
                transition: border-color 0.3s ease;
            }

            .login_design:focus {
                border-color: #3498db;
                outline: none;
            }

            .login_btn {
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

            .login_btn:hover {
                background-color: #2980b9;
            }

            .forgot-password {
                color: #3498db;
                font-size: 14px;
                text-decoration: none;
                margin-top: 10px;
                display: block;
            }

            .forgot-password:hover {
                text-decoration: underline;
            }

            .g_id_signin {
                display: flex;
                justify-content: center;
                align-items: center;
                margin-bottom: 20px;
                width: 100%;
            }

            .separator {
                margin: 20px 0;
                text-align: center;
                color: #ccc;
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

            @media (max-width: 480px) {
                .login-form-wrapper {
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
            <div class="login-form-wrapper">
                <h2>Log In to Your Account</h2>

                <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                    data-text="Sign in with Google" data-shape="rectangular" data-logo_alignment="left">
                </div>

                <div class="separator">
                    <span>or</span>
                </div>

                <form action="sign_in.php" method="post">
                    <input type="text" class="form-control login_design" name="user_email" id="user_email" placeholder="Email" autocomplete="off" required>
                    <input type="password" class="form-control login_design" name="user_password" id="user_password" placeholder="Password" autocomplete="off" required>
                    <a href="#" class="forgot-password">Forgot password?</a>

                    <button class="login_btn" type="submit">Log In</button>
                </form>

                <div class="container">
                    <small>Don't have an account yet? <a href="sign_up.php">Sign Up</a></small>
                </div>
            </div>
        </div>

        <hr class="mx-5 mt-5 mb-3">

        <?php include "../navigation/user_footer.php"; ?>

        <script src="https://accounts.google.com/gsi/client" async defer></script>

        <script defer src="../assets/script/user_script.js"></script>

        <script>
            window.onload = function () {
                google.accounts.id.initialize({
                    client_id: '871355226961-19ip522e0enk01oofpqdbscedb6r2ini.apps.googleusercontent.com', // Replace with your Google client ID
                    callback: handleCredentialResponse
                });

                google.accounts.id.renderButton(
                    document.querySelector(".g_id_signin"),
                    { theme: "outline", size: "large" }
                );
            }

            function handleCredentialResponse(response) {
                console.log("Hello");

                const data = response.credential;

                // Parse the Google user profile information from the response
                const profileObj = jwt_decode(data); // Decode the JWT token

                // Get the profile picture URL
                const profileImageUrl = profileObj.picture;

                // Send data including the image URL to the server using AJAX
                fetch('../assets/php_script/google_callback.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        credential: profileObj,
                        profile_picture: profileImageUrl
                    })
                })
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            window.location.href = 'index.php';
                        } else {
                            alert('Google login failed');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            }
        </script>
    </body>
</html>
