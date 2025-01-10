<?php
    session_start();
    include '../../render/connection.php';

    if (isset($_POST['submit'])) {
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];
        $confirmPassword = $_POST['confirm_password'];

        // Check if the current password is correct
        $email = $_SESSION['email']; // assuming email is stored in session
        $sql = "SELECT * FROM user_account WHERE email = '$email'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($currentPassword, $row['password'])) {
                // Check if new password and confirm password match
                if ($newPassword === $confirmPassword) {
                    // Hash the new password
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                    // Update the password in the database
                    $updateSql = "UPDATE user_account SET password = '$hashedPassword' WHERE email = '$email'";
                    if (mysqli_query($conn, $updateSql)) {
                        $redirectUrl = "../../user/user_profile.php"; 
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
            echo "User not found.";
        }
    }
?>
