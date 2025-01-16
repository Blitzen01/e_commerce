<?php
include '../../render/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the booking_id from the form
    $booking_id = $_POST['booking_id'];

    // Fetch the booking data from the 'booked' table
    $sql = "SELECT * FROM booked WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $booking_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $name = $row['name'];
            $email = $row['email'];
            $address = $row['address'];
            $contact_number = $row['contact_number'];
            $date = $row['date'];
            $time = $row['time'];
            $type_of_booking = $row['type_of_booking'];
            $kind_of_booking = $row['kind_of_booking'];
            $mob = $row['mob']; // Mode of Booking
            $price = $row['price'];
            $remarks = $row['remarks'];
            $status = "Booking Placed";

            // Insert the data into the 'accepted_bookings' table
            $insert_sql = "INSERT INTO booking (name, email, address, contact_number, date, time, type_of_booking, kind_of_booking, mob, price, remarks, status) 
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = mysqli_prepare($conn, $insert_sql);

            if ($insert_stmt) {
                mysqli_stmt_bind_param($insert_stmt, "sssssssssdss", $name, $email, $address, $contact_number, $date, $time, $type_of_booking, $kind_of_booking, $mob, $price, $remarks, $status);

                if (mysqli_stmt_execute($insert_stmt)) {
                    // After successful insertion, delete the booking from 'booked' table
                    $delete_sql = "DELETE FROM booked WHERE id = ?";
                    $delete_stmt = mysqli_prepare($conn, $delete_sql);

                    if ($delete_stmt) {
                        mysqli_stmt_bind_param($delete_stmt, "i", $booking_id);

                        if (mysqli_stmt_execute($delete_stmt)) {
                            // Redirect to the bookings page after success
                            $redirectUrl = "../../admin/web_content/bookings.php";
                            echo '<script type="text/javascript">';
                            echo 'window.location.href = "' . $redirectUrl . '";';
                            echo '</script>';
                            exit;
                        } else {
                            echo "Error deleting booking from booked table: " . mysqli_error($conn);
                        }
                    } else {
                        echo "Error preparing delete statement: " . mysqli_error($conn);
                    }
                } else {
                    echo "Error inserting booking into accepted_bookings: " . mysqli_error($conn);
                }
            } else {
                echo "Error preparing insert statement: " . mysqli_error($conn);
            }
        } else {
            echo "Booking not found!";
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing select statement: " . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
