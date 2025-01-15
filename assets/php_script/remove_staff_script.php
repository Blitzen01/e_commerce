<?php
include '../../render/connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staff_id = $_POST['remove_staff']; // Get the selected staff ID from the form

    // Fetch staff details before deleting
    $fetch_sql = "SELECT * FROM admin_account WHERE id = '$staff_id'";
    $fetch_result = mysqli_query($conn, $fetch_sql);

    if ($fetch_result && mysqli_num_rows($fetch_result) > 0) {
        $staff_data = mysqli_fetch_assoc($fetch_result);

        // Insert staff data into the archive_staff table
        $archive_sql = "INSERT INTO archive_staff (id, username, password, first_name, last_name, email, contact_number, gender, birthday, bio, profile_picture, role, address)
                        VALUES ('{$staff_data['id']}', '{$staff_data['username']}', '{$staff_data['password']}', '{$staff_data['first_name']}', '{$staff_data['last_name']}', 
                                '{$staff_data['email']}', '{$staff_data['contact_number']}', '{$staff_data['gender']}', '{$staff_data['birthday']}', 
                                '{$staff_data['bio']}', '{$staff_data['profile_picture']}', '{$staff_data['role']}', '{$staff_data['address']}')";
        $archive_result = mysqli_query($conn, $archive_sql);

        if ($archive_result) {
            // Delete staff from admin_account table
            $delete_sql = "DELETE FROM admin_account WHERE id = '$staff_id'";
            $delete_result = mysqli_query($conn, $delete_sql);

            if ($delete_result) {
                $redirectUrl = "../../admin/web_content/staff.php";
                // Redirect to the staff page
                echo '<script type="text/javascript">';
                echo 'window.location.href = "' . $redirectUrl . '";';
                echo '</script>';
            } else {
                // Error message if delete fails
                echo '<script type="text/javascript">';
                echo 'alert("Error deleting staff: ' . mysqli_error($conn) . '");';
                echo 'window.history.back();';
                echo '</script>';
            }
        } else {
            // Error message if archiving fails
            echo '<script type="text/javascript">';
            echo 'alert("Error archiving staff: ' . mysqli_error($conn) . '");';
            echo 'window.history.back();';
            echo '</script>';
        }
    } else {
        // Error message if staff ID is invalid
        echo '<script type="text/javascript">';
        echo 'alert("Invalid staff ID selected.");';
        echo 'window.history.back();';
        echo '</script>';
    }

    // Close database connection
    mysqli_close($conn);
}
?>
