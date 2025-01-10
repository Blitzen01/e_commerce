<?php
    session_start();
    include '../../render/connection.php';

    if (isset($_POST['submit'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if the current password is correct
        $email = $_SESSION['admin_email']; // assuming email is stored in session
        $sql = "SELECT * FROM admin_account WHERE email = '$email'"; // Assuming you're checking for admin account
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            
            // Check if the current password matches the stored password
            if ($currentPassword === $row['password']) {
                // Check if new password and confirm password match
                if ($newPassword === $confirmPassword) {
                    // Update the password in the database
                    $updateSql = "UPDATE admin_account SET password = '$newPassword' WHERE email = '$email'"; // Update directly since it's not hashed
                    if (mysqli_query($conn, $updateSql)) {
                        $redirectUrl = "../../admin/web_content/account_settings.php"; // Redirect to admin dashboard after success
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "' . $redirectUrl . '";';
                        echo '</script>';
                    } else {
                        echo "Error updating password: " . mysqli_error($conn);
                    }
                } else {
                    echo "New password and confirmation do not match.";
                }
            } else {
                echo "Current password is incorrect.";
            }
        } else {
            echo "Admin not found.";
        }
    }
?>
