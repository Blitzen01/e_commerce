<?php
    include '../../render/connection.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the booking_id from the form
        $booking_id = $_POST['booking_id'];

        // Fetch the booking data from the 'booked' table
        $sql = "SELECT * FROM booked WHERE id = '$booking_id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            while($row = mysqli_fetch_assoc($result)) {
                $name = $row['name'];
                $email = $row['email'];
                $address = $row['address'];
                $contact_number = $row['contact_number'];
                $date = $row['date'];
                $time = $row['time'];
                $type_of_booking = $row['type_of_booking'];
                $price = $row['price'];
                
                // Insert the data into the 'accepted_bookings' table
                $insert_sql = "INSERT INTO booking (name, email, address, contact_number, date, time, type_of_booking, price)
                VALUES ('$name', '$email', '$address', '$contact_number', '$date', '$time', '$type_of_booking', '$price')";

                if (mysqli_query($conn, $insert_sql)) {
                    // After successful insertion, delete the booking from 'booked' table
                    $delete_sql = "DELETE FROM booked WHERE id = '$booking_id'";
                    if (mysqli_query($conn, $delete_sql)) {
                        // Redirect to the bookings page after success
                        $redirectUrl = "../../admin/web_content/bookings.php"; 
                        echo '<script type="text/javascript">';
                        echo 'window.location.href = "' . $redirectUrl . '";';
                        echo '</script>';
                        exit; // Ensure no further code is executed after the redirect
                    } else {
                        echo "Error deleting booking from booked table!";
                    }
                } else {
                    echo "Error inserting booking into accepted_bookings!";
                }
            }
        } else {
            echo "Booking not found!";
        }
    }
?>
