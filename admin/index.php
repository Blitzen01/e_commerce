<?php
include "../assets/cdn/cdn_links.php";
include "../render/connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve input and password from the form
    $input = $_POST["admin_username"]; // User can input either email or username
    $password = $_POST["admin_password"];

    // Determine whether the input is an email or a username
    if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
        // Input is an email
        $sql = "SELECT * FROM admin_account WHERE email = ?";
    } else {
        // Input is a username
        $sql = "SELECT * FROM admin_account WHERE username = ?";
    }

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row was returned
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify the password (you should ideally hash and verify using password_hash() and password_verify())
        if ($password === $row['password']) { // Replace with password_verify($password, $row['password']) if hashing is used
            // Start the session and redirect on successful login
            session_start();
            $_SESSION['email'] = $row['email']; // Store email in session
            echo "<script>
                    window.location.href = 'web_content/calendar.php';
                  </script>";
        } else {
            // Incorrect password
            echo "<script>
                    alert('Invalid password. Please try again.');
                  </script>";
        }
    } else {
        // No matching user
        echo "<script>
                alert('Invalid username or email. Please try again.');
              </script>";
    }

    // Close prepared statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin: HFA Computer Parts and Repair Services</title>

        <link rel="stylesheet" href="../assets/style/admin_style.css">
        <link rel="icon" href="../assets/image/hfa_logo.png" type="image/png">

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
                    <form action="index.php" method="post">
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
