<?php
    include "../assets/cdn/cdn_links.php";
    include "../render/connection.php";

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve email/username and password from the form
        $email = $_POST["user_username"]; // Corrected field name
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
                session_start();
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


        // Close prepared statement
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/user_style.css">

        <style>
            /* Container for the layout */
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
            <div class="w-25" style="max-width: 800px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); border-radius: 8px; overflow: hidden;">

                <div class="text-center my-3">
                        <span>or</span>
                    </div>
                <!-- Login Form Section (Left side for desktop, bottom for mobile) -->
                <div id="login_form_layout" class="p-4">
                    <form action="sign_in.php" method="post">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="user_username" id="user_username" placeholder="Email or Username" autocomplete="off">
                        </div>
                        <div class="mb-3">
                            <input type="password" class="form-control" name="user_password" id="user_password" placeholder="Password" autocomplete="off">
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

        <script defer src="../assets/script/user_script.js"></script>
    </body>
</html>