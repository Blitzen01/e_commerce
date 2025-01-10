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
            // Verify the password
            if ($password == $row['password']) {
                // Start the session and redirect on successful login
                $_SESSION['email'] = $email; // Store the email in session
                echo "<script>
                            window.location.href = 'index.php';
                        </script>";
            }
        } else {
            // Display alert for invalid email or password
            echo "<script>
                    alert('Invalid email. Please try again.');
                </script>";
        }
    }

    if(isset($_SESSION['email'])) {
        $email = $_SESSION['email']; // User's email stored in the session

        // Check if the user is logging in for the first time
        $sql = "SELECT is_login FROM user_account WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        $isFirstLogin = $user['is_login'] == 0; // Check if `is_login` is 0
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

                <div class="container d-flex justify-content-center mt-4 rounded">
                    <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                        data-text="sign_in_with" data-shape="rectangular" data-logo_alignment="left"></div>
                </div>

                <div class="text-center my-1">
                    <span>or</span>
                </div>

                <div id="login_form_layout" class="p-3">
                    <form action="sign_in.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="user_email" id="user_email" placeholder="Email"
                                autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="user_password" id="user_password"
                                placeholder="Password" autocomplete="off">
                            <a href="#" class="nav-link text-primary p-0 mt-2">Forgot password?</a>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-danger w-100" type="submit">Log In</button>
                        </div>
                    </form>
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
                    client_id: '341495212949-oqiqf3dfcte9ba1hhqu079mbohlcsgr8.apps.googleusercontent.com', // Replace with your Google client ID
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

